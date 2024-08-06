@extends('index')

@section('page')
    <div class="flex flex-col p-6">
        <div class="flex gap-4">
            <div class="flex w-1/3 flex-col justify-center gap-2 rounded-2xl border border-gray-300 bg-white px-4 py-6">
                <p class='text-sm'>Buku dipinjam</p>
                <h1>14</h1>
            </div>

            <div class="flex w-1/3 flex-col justify-center gap-2 rounded-2xl border border-gray-300 bg-white px-4 py-6">
                <p class='text-sm'>Telat dikembalikan</p>
                <h1>14</h1>
            </div>

            <div class="flex w-1/3 flex-col justify-center gap-2 rounded-2xl border border-gray-300 bg-white px-4 py-6">
                <p class='text-sm'>Total buku</p>
                <h1>14</h1>
            </div>
        </div>
    </div>
@endsection
