<?php

namespace App\Livewire;

use App\Models\Vendor as VendorModel;
use Livewire\Component;

class Vendor extends Component
{
    public $vendors, $name, $description, $vendor_id;
    public $updateVendor = false;
    public $openingModal = false;
    protected $listeners = [
        'deleteVendor' => 'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'name' => 'required',
        'description' => 'required'
    ];

    public function openModal()
    {
        $this->openingModal = true;
    }

    public function render()
    {
        $this->vendors = VendorModel::select('id', 'name', 'description')->orderby('id', 'desc')->get();
        return view('livewire.vendor');
    }
    public function resetFields()
    {
        $this->name = '';
        $this->description = '';
    }
    public function store()
    {
        // Validate Form Request
        $this->validate();
        try {
            // Create Vendor
            VendorModel::create([
                'name' => $this->name,
                'description' => $this->description
            ]);

            // Set Flash Message
            session()->flash('success', 'Vendor Created Successfully!!');
            // Reset Form Fields After Creating Vendor
            $this->resetFields();

            $this->openingModal = false;
        } catch (\Exception $e) {
            // Set Flash Message
            session()->flash('error', 'Something goes wrong while creating vendor!!');
            // Reset Form Fields After Creating Vendor
            $this->resetFields();
        }
    }
    public function edit($id)
    {
        $vendor = VendorModel::findOrFail($id);
        $this->name = $vendor->name;
        $this->description = $vendor->description;
        $this->vendor_id = $vendor->id;
        $this->updateVendor = true;
        $this->openingModal = true;
    }
    public function cancel()
    {
        $this->updateVendor = false;
        $this->resetFields();
    }
    public function update()
    {
        // Validate request
        $this->validate();
        try {
            // Update vendor
            VendorModel::find($this->vendor_id)->fill([
                'name' => $this->name,
                'description' => $this->description
            ])->save();
            session()->flash('success', 'Vendor Updated Successfully!');

            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong while updating vendor!');
            $this->cancel();
        }
        $this->openingModal = false;
    }
    public function destroy($id)
    {
        try {
            VendorModel::find($id)->delete();
            session()->flash('success', "Vendor Deleted Successfully!!");
        } catch (\Exception $e) {
            session()->flash('error', "Something goes wrong while deleting vendor!!");
        }
    }
}
