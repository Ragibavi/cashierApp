@extends('layouts.app')

@section('title', 'User')

@push('style')

@endpush

@section('content')
<div class="main-content-table">
    <section class="section">
        <div class="margin-content">
            <div class="container-sm">
                <div class="section-header">
                    <h1>Produk</h1>
                </div>
                @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                <div class="section-body">
                    <div class="table-responsive">
                        <div class="row mb-3">
                            <div class="col-md-12 d-flex justify-content-between align-items-center">
                                <form action="{{ route('user.index') }}" method="GET" class="d-flex" style="max-width: 100%%;">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control rounded" placeholder="Search">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary rounded ml-2" type="submit">Search</button>
                                        </div>
                                    </div>
                                </form>
                                <a href="{{ route('product.create') }}" class="btn btn-success ml-2 p-2">
                                    Create Product
                                </a>
                            </div>
                        </div>                                           
                        <table class="table table-bordered" style="background-color: #f3f3f3">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Gambar</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $index => $item)
                                    <tr>
                                        <td>{{ $products->firstItem() + $index }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->image }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('product.edit', $item->id) }}" class="btn btn-primary">Edit Stok</a>
                                            <a href="{{ route('product.edit', $item->id) }}" class="btn btn-primary">Edit</a>
                                            <form action="{{ route('product.destroy', $item->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>                                
                        </table>
                        <div class="d-flex justify-content-end mt-3">
                            {{ $products->links() }}
                        </div>                                                     
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- JS Libraries -->

<!-- Page Specific JS File -->
@endpush