@extends('templates.main')

@section('content')
    <div class="row">
        <div class="col-6">
            <h5>Tambah Kontak</h5>
            <hr>
            <form enctype="multipart/form-data" method="POST" action="{{ route('contact.store') }}">
                @csrf
                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input name="name" type="name" class="form-control @error('name') is-invalid @enderror" id="name"
                            value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="address" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="address"
                            id="address" rows="3">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="phone" class="col-sm-2 col-form-label">No. Telp</label>
                    <div class="col-sm-10">
                        <input name="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            id="phone" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="avatar" class="col-sm-2 col-form-label">Avatar</label>
                    <div class="col-sm-2">
                        <img id="preview" src="{{ asset('assets/img/avatar.png') }}" class="img-fluid rounded float-start"
                            alt="avatar" accept="image/*" value="{{ old('avatar') }}">
                    </div>
                    <div class="col-sm-8">
                        <input name="avatar" class="form-control @error('avatar') is-invalid @enderror" id="avatar"
                            type="file" id="avatar" value="{{ old('avatar') }}">
                        @error('avatar')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="float-end">
                    <a href="{{ route('contact.index') }}" class="btn btn-warning">Back</a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        let avatar = document.querySelector('#avatar');
        let preview = document.querySelector('#preview');
        avatar.onchange = evt => {
            const [file] = avatar.files;
            if (file) {
                preview.src = URL.createObjectURL(file)
            }
        }
    </script>
@endsection
