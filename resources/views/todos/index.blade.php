<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
         @endif
    


        <form method="POST" action="{{ route('todos.store') }}">
            @csrf

            <input type="text" 
                name="task" 
                placeholder="Task"
                class="form-control custom-spacing block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm "
            >
            <x-input-error :messages="$errors->get('task')" class="mt-2" />

            <textarea
                name="description"
                placeholder="{{ __('Description') }}"
                class="form-control custom-spacing block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('description') }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
            <x-primary-button class="mt-3">{{ __('Todo') }}</x-primary-button>
        </form>

        <table class="table mt-4">
            <thead>
                <tr class="table-row table-header">
                    <th class="table-cell text-left" style="width: 20%;">Task</th>
                    <th class="table-cell text-left" style="width: 40%;">Description</th>
                    <th class="table-cell text-left" style="width: 25%;">Status</th>
                    <th class="table-cell text-left" style="width: 15%;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($todos as $todo)
                    @if ($todo->user->id === auth()->user()->id)

                        <tr class="table-row">
                            <td class="table-cell" style="width: 20%;">
                                <span class="{{ $todo->status === 'Completed' ? 'completed-task' : '' }}">{{ $todo->task }}</span>
                            </td>
                            <td class="table-cell" style="width: 40%;">{{ $todo->description }}</td>
                            <td class="table-cell" style="width: 25%">                           
                                <div class="form-group">
                                    <form method="POST" action="{{ route('todos.update', $todo) }}">
                                        @csrf
                                        @method('PUT')
                                    <select name="status" id="status" class="form-control status-select" style="width: 200px;" onchange="this.form.submit()">
                                    <option value="Not started"{{ $todo->status === 'Not started' ? ' selected' : '' }}>Not started</option>
                                    <option value="In progress"{{ $todo->status === 'In progress' ? ' selected' : '' }}>In progress</option>
                                    <option value="Completed"{{ $todo->status === 'Completed' ? ' selected' : '' }}>Completed</option>
                                </select>
                            </form>
                        </div>                        
                    </td>
                    
                    <td class="table-cell" style="width: 15%;">
                        <div class="form-group flex">
                            @if ($todo->user->is(auth()->user()))
                            <x-dropdown>
                                <x-slot name="trigger">
                                    <a href="{{ route('todos.edit', $todo) }}">
                                        <button type="submit" class="btn btn-link p-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil ml-2 text-blue-500" viewBox="0 0 16 16">
                                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                            </svg>
                                        </button>
                                    </a>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('todos.edit', $todo)"></x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
        
                            <form method="POST" action="{{ route('todos.destroy', $todo) }}">
                                @csrf
                                @method('DELETE')
                                    <button type="submit" class="btn btn-link p-0" onclick="event.preventDefault(); this.closest('form').submit();">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash ml-2 text-danger" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        

    </div>
</x-app-layout>
