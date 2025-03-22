<?php
use Illuminate\Support\Facades\DB;
?>
@extends('layouts.app')

@section('title', 'Penjualan')

@push('style')
@endpush

@section('content')
<div class="main-content-table">
    <section class="section">
        <div class="margin-content">
            <div class="container-sm">
                <div class="section-header">
                    <h1>Penjualan</h1>
                </div>
                <div class="section-body">
                    <div class="table-responsive">
                        <div class="row mb-3">
                            <div class="col-md-12 d-flex justify-content-between align-items-center">
                                <form action="{{ route('sales.index') }}" method="GET" class="d-flex"
                                style="max-width: 100%%;">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control rounded"
                                    placeholder="Search">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary rounded ml-2" type="submit">Search</button>
                                    </div>
                                </div>
                            </form>
                            @can('superadmin')
                            <a href="{{ route('sales.create') }}" class="btn btn-success ml-2 p-2">
                                Tambah Penjualan
                            </a>
                            @endcan
                        </div>
                    </div>
                    <table class="table table-bordered" style="background-color: #f3f3f3">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Tanggal Penjualan</th>
                                <th>Total Harga</th>
                                <th>Dibuat Oleh</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach ($sales as $index => $item)
                                <td>{{ $sales->firstItem() + $index }}</td>
                                <td>{{ $item->customer_name }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ 'Rp ' . number_format($item->total_amount, 0, ',', '.') }}</td>
                                <td>{{ DB::table('users')->where('id', $item->user_id)->value('name') }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary edit-stock-btn"
                                    data-id="{{ $item->id }}" data-name="{{ $item->invoice_number }}"
                                    data-quantity="{{ $item->quantity }}" data-toggle="modal"
                                    data-target="#editStockModal">
                                    Lihat
                                </button>
                                <a href="{{ route('sales.edit', $item->id) }}"
                                    class="btn btn-primary">Unduh Bukti</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-3">
                            {{ $sales->links() }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<!-- Edit Stock Modal -->
<div class="modal fade" id="editStockModal" tabindex="-1" role="dialog" aria-labelledby="editStockModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <form id="editStockForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStockModalLabel">Edit Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="productName" class="font-weight-bold"></p>
                <div class="form-group">
                    <label for="quantityInput">Quantity</label>
                    <input type="number" min="0" class="form-control" id="quantityInput" name="quantity"
                    required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Update Stock</button>
            </div>
        </div>
    </form>
</div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
        
        const editStockButtons = document.querySelectorAll('.edit-stock-btn');
        const editStockForm = document.getElementById('editStockForm');
        const quantityInput = document.getElementById('quantityInput');
        const productName = document.getElementById('productName');
        
        editStockButtons.forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const quantity = button.getAttribute('data-quantity');
                
                productName.textContent = `Product: ${name}`;
                quantityInput.value = quantity;
                
                editStockForm.action = `/sales/${id}/update-stock`;
            });
        });
        
        @if (session('message'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('message') }}',
            confirmButtonColor: '#3085d6'
        });
        @endif
        
        @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#d33'
        });
        @endif
    });
    </script>
@endpush
