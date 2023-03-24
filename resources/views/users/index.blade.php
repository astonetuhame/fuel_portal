<x-layouts.app>
  @section('dashboard', 'Manage Users')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            @can('user-create')
            <div class="pull-right">
                <a class="btn btn-success mb-2" href="{{ route('users.create') }}"> Create New User</a>
            </div>
            @endcan
        </div>
    </div>
    
   
    
    <table class="table table-bordered">
     <tr>
       <th>No</th>
       <th>Name</th>
       <th>Email</th>
       <th>Roles</th>
       <th width="280px">Action</th>
     </tr>
     @foreach ($data as $key => $user)
      <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
          @if(!empty($user->getRoleNames()))
            @foreach($user->getRoleNames() as $v)
               <label class="badge badge-success">{{ $v }}</label>
            @endforeach
          @endif
        </td>
        <td>
           <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
           @can('user-edit')
           <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
           @endcan
           @can('user-delete')
            {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
            @endcan
        </td>
      </tr>
     @endforeach
    </table>
    
    
    {!! $data->render() !!}
    
</x-layouts.app>