import React from 'react';
import MainLayout from '../../Layouts/MainLayout'; // Import layout

export default function Index({ barangs, categories }) {
    return (
        <MainLayout>
            {/* Semua kode di bawah ini akan muncul di tempat {children} tadi */}
            <div className="row">
                <div className="col-12">
                    <div className="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 className="mb-sm-0 font-size-18">Manajemen Barang</h4>
                    </div>
                </div>
            </div>

            <div className="card">
                <div className="card-body">
                    <p>Selamat datang di sistem logistik baru dengan React!</p>
                    {/* Taruh tabel barang kamu di sini */}
                </div>
            </div>
        </MainLayout>
    );
}