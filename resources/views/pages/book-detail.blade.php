@extends('index')

@section('page')
    @if (session('success'))
    @endif
    <form
        class="flex flex-col gap-6 p-6"
        type="multipart/form-data"
        action="/buku/{{ $book->id }}"
        method="POST"
    > </form>

    <form
        method="POST"
        onSubmit="return confirm('Apakah anda yakin ingin menghapus buku ini?')"
        class="px-6 pb-10"
    >
        @csrf
        @method('delete')

        <button
            class="flex h-10 w-full items-center justify-center gap-2 rounded-full bg-red-600 text-sm font-bold text-white"
            name="_method"
            value="delete"
        >
            Hapus
        </button>
    </form>
@endsection
