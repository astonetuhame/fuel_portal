<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $action;
    public $selectedItem;
    // public $perPage = 10;
    public $sortAsc = true;
    public $sortField = "comment";


    protected $listeners = ['refreshParent' => '$refresh'];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }
        $this->sortField = $field;
    }

    public function selectItem($commentID, $action)
    {
        $this->selectedItem = $commentID;
        if ($action == 'delete') {
            $this->emit('openDeleteModal');
        } else {
            $this->emit('getCommentID', $this->selectedItem);
            $this->emit('openFormModal');
        }
    }


    public function delete()
    {
        Comment::destroy($this->selectedItem);
        $this->emit('closeDeleteModal');
        $this->emit('alert', ['type' => 'success', 'message' => 'Deleted Successfully']);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $comments = Comment::where('comment', 'LIKE', "%{$this->search}%")
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate(50);

        return view('livewire.comments', compact('comments'));
    }
}
