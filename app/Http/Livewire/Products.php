<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $search, $search_category = "";
    public $sub_id, $description, $size, $amount, $cost, $price, $category, $owner;


    public function render()
    {
        $products = Product::when($this->search_category, function ($q) {
            $q->where('category', $this->search_category);
        }, function ($q) {
            $q->where('id', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->orWhere('owner', 'like', '%' . $this->search . '%');
        })->paginate(10);

        return view('livewire.products', compact('products'));
    }

    protected $rules = [
        'description' => 'required|max:100',
        'size' => 'required|max:10',
        'amount' => 'required|numeric',
        'cost' => 'required|numeric',
        'price' => 'required|numeric',
        'category' => 'required',
        'owner' => 'required|max:20',
    ];

    public function resetInputFields()
    {
        $this->reset();
    }

    public function store()
    {
        $data = $this->validate();
        Product::updateOrCreate(['id' => $this->sub_id], $data);
        $this->reset();
        session()->flash('message', $this->sub_id ?  'Actualizado' : 'Guardado');
        $this->emit('closeModal');
    }

    public function delete($id)
    {
        Product::where('id', $id)->delete();
        session()->flash('message', 'Eliminado');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $this->sub_id = $product->id;
        $this->description = $product->description;
        $this->size = $product->size;
        $this->amount = $product->amount;
        $this->cost = $product->cost;
        $this->price = $product->price;
        $this->category = $product->category;
        $this->owner = $product->owner;
        $this->emit('openModal');
    }
}
