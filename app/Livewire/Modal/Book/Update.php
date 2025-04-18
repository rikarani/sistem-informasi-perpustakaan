<?php

namespace App\Livewire\Modal\Book;

use App\Models\Book;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;

class Update extends Component
{
    public ?Book $book = null;

    public string $category_id = '';

    public string $code;

    public string $author;

    public string $title;

    public string $publisher;

    public string $year;

    public string $source;

    public string $price;

    public string $description;

    #[On('update')]
    public function prepare(string $id)
    {
        $this->book = Book::findOrFail($id);

        $this->category_id = $this->book->category_id;
        $this->code = $this->book->code;
        $this->author = $this->book->author;
        $this->title = $this->book->title;
        $this->publisher = $this->book->publisher;
        $this->year = $this->book->year;
        $this->source = $this->book->source;
        $this->price = $this->book->price;
        $this->description = $this->book->description;

        $this->dispatch('open-modal', modal: 'update book');
    }

    public function update()
    {
        $data = $this->validate();

        $this->book->update([
            ...$data,
            'price' => $data['price'] === '' ? 0 : $data['price'],
        ]);

        Session::flash('success', 'Buku berhasil diperbarui');
        $this->dispatch('close-modal');

        return $this->redirectRoute('manage book');
    }

    public function rules()
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'code' => ['required', 'string', Rule::unique('books', 'code')->ignore($this->book->id)->whereNull('deleted_at')],
            'stock' => 'required|numeric',
            'author' => 'required|string',
            'title' => 'required|string',
            'publisher' => 'required|string',
            'year' => 'required',
            'source' => 'required',
            'price' => 'nullable|numeric',
            'description' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Kode buku tidak boleh kosong',
            'code.string' => 'Kode buku harus berupa string',
            'code.unique' => 'Kode buku sudah ada',
            'title.required' => 'Judul buku tidak boleh kosong',
            'title.string' => 'Judul buku harus berupa string',
        ];
    }

    public function render()
    {
        return view('livewire.modal.book.update')->with([
            'categories' => Category::all(),
        ]);
    }
}
