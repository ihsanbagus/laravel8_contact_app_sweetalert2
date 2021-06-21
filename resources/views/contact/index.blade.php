@extends('templates.main')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/my.css') }}">
@endsection

@section('content')
    @if (session('pesan'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            {{ session('pesan') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row row-cols-5">
        @foreach ($contacts as $c)
            <div class="col mb-3">
                <div class="card shadow" style="height: 500px;">
                    <img src="{{ Storage::url('img/' . $c->avatar) }}" class="card-img-top" alt="avatar"
                        style="max-height: 200px;">
                    <div class="card-body">
                        <strong class="card-title d-inline-block text-truncate mw-150">{{ $c->name }}</strong>
                        <p class="card-text">
                            {{ $c->address }}
                        </p>
                        <sup>{{ $c->phone }}</sup>
                    </div>
                    <div class="card-footer d-flex justify-content-evenly">
                        <a href="{{ route('contact.edit', $c->id) }}" class="btn btn-sm btn-primary">edit</a>
                        <form action="{{ route('contact.destroy', $c->id) }}" method="post"
                            onsubmit="event.preventDefault();hapus(this);">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
        {{ $contacts->links() }}
    </div>
@endsection

@push('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const hapus = e => {
            let url = e.getAttribute('url');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((r) => {
                if (r.isConfirmed) {
                    console.log(e.submit());
                }
            })
        }
    </script>
@endpush
