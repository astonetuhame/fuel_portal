<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;

class CommentsForm extends Component
{
    public $comment;
    public $commentID;

    protected $listeners = ['getCommentID', 'forcedClosedModal'];

    public function getCommentID($commentID)
    {
        $this->commentID = $commentID;

        $model = Comment::find($this->commentID);

        $this->comment = $model->comment;
        $this->type = $model->type;
    }

    public function forcedClosedModal()
    {
        //reset public variables
        $this->resetInputFields();

        //reset validation errors
        $this->resetErrorBag();
        $this->resetValidation();
    }

    private function resetInputFields()
    {
        $this->commentID = null;
        $this->comment = null;
    }

    public function addComment()
    {

        $this->validate([
            'comment' => 'required',
        ]);

        $validatedData = [
            'comment' => $this->comment,
        ];

        if ($this->commentID) {
            Comment::find($this->commentID)->update($validatedData);
            $this->emit('alert', ['type' => 'success', 'message' => 'Comment Updated Successfully']);
        } else {
            Comment::create($validatedData);
            $this->emit('alert', ['type' => 'success', 'message' => 'Comment Added Successfully']);
        }

        $this->emit('refreshParent');
        $this->emit('closeFormModal');



        $this->resetInputFields();
    }

    public function render()
    {
        return view('livewire.comments-form');
    }
}
