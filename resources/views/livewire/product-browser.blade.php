<div class="flex flex-col md:flex-row gap-8 max-w-6xl mx-auto px-4 mb-12">
    
    <!-- Sidebar / Filters -->
    <aside class="w-full md:w-1/4 bg-gray-50 p-6 rounded-lg border border-gray-200 shadow-sm self-start">   
        <h2 class="text-xl font-bold text-gray-800 mb-5">Filters</h2>

        <div class="mb-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-2">Search</h3>
            <input 
                wire:model.live.debounce.300ms="search" 
                type="text" 
                placeholder="Product name..." 
                class="w-full border border-gray-300 px-3 py-2 rounded focus:ring-2 focus:ring-blue-400"
            />
        </div>

        <div class="mb-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-2">Categories</h3>
            <ul class="space-y-1">
                <li>
                    <button 
                        wire:click="$set('category', '')" 
                        class="text-left w-full text-blue-600 hover:text-blue-800 hover:underline transition duration-150 {{ !$category ? 'font-bold underline' : '' }}"
                    >
                        All Products
                    </button>
                </li>
                @foreach ($categories as $c)
                <li>
                    <button 
                        wire:click="$set('category', '{{ $c }}')" 
                        class="text-left w-full text-blue-600 hover:text-blue-800 hover:underline transition duration-150 {{ $category == $c ? 'font-bold underline' : '' }}"
                    >
                        {{ $c }}
                    </button>
                </li>
                @endforeach
            </ul>
        </div>
    </aside>

    <!-- Product Grid -->
    <div class="w-full md:w-3/4">
        <!-- Status Indicator for Livewire -->
        <div wire:loading class="text-sm text-blue-600 mb-2 italic">Searching...</div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($products as $p)
                <div class="bg-white border border-gray-200 rounded-lg shadow hover:shadow-md transition duration-300 flex flex-col h-full">
                    <img
                        src="{{ asset('assets/images/'.strtolower($p->category).'/'.strtolower($p->image)) }}"
                        onerror="this.onerror=null;this.src='{{ asset('assets/images/placeholder.jpg') }}';"
                        alt="{{ $p->name }}"
                        class="w-full h-48 object-contain rounded-t bg-gray-100"
                    />
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $p->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $p->category }}</p>
                        <p class="text-xl font-bold text-green-600 mt-2">{{ $p->formatted_price }}</p>

                        <div class="mt-auto pt-4 flex justify-between items-center">
                            <a
                                href="{{ route('products.show', $p->id) }}"
                                class="text-blue-600 hover:text-blue-800 hover:underline text-sm"
                            >
                                View Details
                            </a>
                            <form method="post" action="{{ route('cart.add') }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $p->id }}" />
                                <button
                                    type="submit"
                                    class="bg-green-500 text-white text-sm px-4 py-1.5 rounded hover:bg-green-600 transition"
                                >
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500">No products found matching your criteria.</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
</div>
