<?php

namespace App\Livewire\Modal\Member;

use App\Models\Member;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;

class Update extends Component
{
    public ?Member $member = null;

    public string $name;

    public string $phone_number;

    #[On(('update'))]
    public function prepare(string $id): void
    {
        $this->member = Member::findOrFail($id);
        $this->fill($this->member);

        $this->dispatch('open-modal', modal: 'update user');
    }

    public function update(): void
    {
        $data = $this->validate();

        $this->member->update($data);

        Session::flash('success', 'Member berhasil diperbarui');
        $this->dispatch('close-modal');

        $this->redirectRoute('manage user');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique('members', 'name')->ignore($this->member->id)->whereNull('deleted_at')],
            'phone_number' => ['required', 'phone:ID', Rule::unique('members', 'phone_number')->ignore($this->member->id)->whereNull('deleted_at')],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama tidak boleh kosong',
            'name.string' => 'Nama harus berupa huruf',
            'name.unique' => 'Member sudah ada',
        ];
    }

    public function render(): View
    {
        return view('livewire.modal.member.update');
    }
}
