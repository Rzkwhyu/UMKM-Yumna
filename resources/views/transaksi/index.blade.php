@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<h1>Data Transaksi</h1>

<a href="{{ route('transaksi.create') }}">
    Tambah Transaksi
</a>

<hr>

@foreach ($transaksi as $item)

    <p>

        {{ $item->barang->nama_barang }}
        |

        {{ $item->nama_pembeli }}
        |

        Qty : {{ $item->qty }}
        |

        Total : Rp. {{ $item->total_harga }}

        <a href="{{ route('transaksi.edit', $item->id) }}">
            Edit
        </a>

        <form action="{{ route('transaksi.destroy', $item->id) }}"
              method="POST">

            @csrf
            @method('DELETE')

            <button type="submit">
                Hapus
            </button>

        </form>

    </p>

@endforeach