<div>
    <!-- Page Heading -->
    <x-heading label="Productos">
        <a href="{{ route('products.register') }}" type="button" class="btn btn-sm btn-primary shadow-sm">
            Agregar
        </a>
    </x-heading>

    <x-dialog>
        <h5 class="font-weight-bold">{{ $product->description }}</h5>
        <div class="mb-2">SKU: {{ $product->SKU }}</div>
        <div class="row">
            <div class="col">
                <div class="mb-2">Costo: {{ $product->format_default_cost }}</div>
                <div class="mb-2">Precio: {{ $product->format_default_price }}</div>
                <div class="mb-2">Propietario: {{ $product->user->name ?? '' }}</div>
                <div class="mb-2">Categoria: {{ $product->category->name ?? '' }}</div>
                <div class="mb-2">
                    Total Comprado: {{ $product->total_purchased }}
                </div>
                <div class="mb-2">
                    Total Costo:
                    {{ $product->format_total_quantity_cost }}
                </div>
                <div class="mb-2">
                    Disponible: {{ $product->available_quantity }}
                </div>
                <div class="mb-2">
                    Costo Disponible:
                    {{ $product->format_current_quantity_cost }}
                </div>
            </div>
            <div class="col">
               <img src="{{ $product->image }}" alt="No hay imagen" class="mx-auto img-preview">
            </div>
        </div>
    </x-dialog>

    <x-table title="Productos">
        @slot('search')
            <div class="row">
                <div class="col-12 col-lg-3">
                    <input type="search" class="form-control " wire:model.debounce.500ms="search" placeholder="Buscar">
                </div>
            </div>
        @endslot
        @slot('header')
            <th>Descripción</th>
            <th>Catalogo</th>
            <th>Costo C/U</th>
            <th>Disponible</th>
            <th>Costo Total</th>
            <th>Opciones</th>
        @endslot
        @forelse ($products as $product)
            <tr>
                <td>
                    <div>
                        <div class="mb-1 text-dark break-45-ch">
                            {{ $product->description }}
                        </div>
                        <span class="text-primary small">
                            {{ $product->SKU }}
                        </span>
                    </div>
                </td>
                <td>
                    @if ($product->status == 1)
                        <span class="badge badge-success">Mostrar</span>
                    @else
                        <span class="badge badge-danger">No mostrar</span>
                    @endif
                </td>
                <td>
                    <div class="text-dark font-weight-bold">
                        {{ $product->format_default_cost }}
                    </div>
                </td>
                <td>{{ $product->available_quantity }}</td>
                <td>
                    <div class="text-dark font-weight-bold">
                        {{ $product->format_current_quantity_cost }}
                    </div>
                </td>
                <td data-title="Opciones">
                    <x-dropdown>
                        <a href="{{ route('stock', $product->id) }}" type="button" class="dropdown-item" >
                            Existencias
                        </a>
                        <button type="button" class="dropdown-item" wire:click="details({{ $product->id }})">
                            Vista previa
                        </button>
                        <a href="{{ route('products.register', $product->id) }}" class="dropdown-item">
                            Editar
                        </a>
                        <button type="button" class="dropdown-item" onclick="confirm_delete()"
                            wire:click="destroy({{ $product->id }})">
                            Eliminar
                        </button>
                    </x-dropdown>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No hay registros</td>
            </tr>
        @endforelse
        @slot('links')
            {!! $products->links() !!}
        @endslot
    </x-table>
</div>
