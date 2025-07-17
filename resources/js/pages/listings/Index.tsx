import React from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { Listing, Paginated } from '@/types/index';

interface Props {
  listings: Paginated<Listing>;
  filters: {
    search: string;
    type: string;
    condition: string;
    min_price: string;
    max_price: string;
  };
}

export default function ListingsIndex({ listings, filters }: Props) {
  const { url } = usePage();
  
  return (
    <AppLayout>
      <Head title="Listings - GameMarket" />
      
      <div className="max-w-7xl mx-auto px-4 py-8">
        {/* Header */}
        <div className="mb-8">
          <h1 className="text-3xl font-bold text-gray-900 dark:text-white mb-4">Browse Listings</h1>
          <p className="text-lg text-gray-600 dark:text-gray-300">
            Find great deals on game items and accessories
          </p>
        </div>

        {/* Filters */}
        <div className="bg-white dark:bg-zinc-900 rounded-lg shadow-md p-8 mb-8">
          <form method="GET" action={route('listings.index')} className="space-y-4">
            <div className="grid grid-cols-1 md:grid-cols-5 gap-6">
              {/* Search */}
              <div className="md:col-span-2">
                <label htmlFor="search" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                  Search
                </label>
                <input
                  type="text"
                  name="search"
                  id="search"
                  defaultValue={filters.search}
                  placeholder="Search listings..."
                  className="w-full px-3 py-2 border border-gray-300 dark:border-zinc-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:text-white"
                />
              </div>

              {/* Type */}
              <div>
                <label htmlFor="type" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                  Type
                </label>
                <select
                  name="type"
                  id="type"
                  defaultValue={filters.type}
                  className="w-full px-3 py-2 border border-gray-300 dark:border-zinc-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:text-white"
                >
                  <option value="">All Types</option>
                  <option value="sell">Sell</option>
                  <option value="buy">Buy</option>
                </select>
              </div>

              {/* Condition */}
              <div>
                <label htmlFor="condition" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                  Condition
                </label>
                <select
                  name="condition"
                  id="condition"
                  defaultValue={filters.condition}
                  className="w-full px-3 py-2 border border-gray-300 dark:border-zinc-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:text-white"
                >
                  <option value="">Any Condition</option>
                  <option value="new">New</option>
                  <option value="like_new">Like New</option>
                  <option value="used">Used</option>
                  <option value="damaged">Damaged</option>
                </select>
              </div>

              {/* Price Range */}
              <div className="md:col-span-2 grid grid-cols-2 gap-4">
                <div>
                  <label htmlFor="min_price" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Min Price
                  </label>
                  <input
                    type="number"
                    name="min_price"
                    id="min_price"
                    defaultValue={filters.min_price}
                    placeholder="Min"
                    className="w-full px-3 py-2 border border-gray-300 dark:border-zinc-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:text-white"
                  />
                </div>
                <div>
                  <label htmlFor="max_price" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Max Price
                  </label>
                  <input
                    type="number"
                    name="max_price"
                    id="max_price"
                    defaultValue={filters.max_price}
                    placeholder="Max"
                    className="w-full px-3 py-2 border border-gray-300 dark:border-zinc-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:text-white"
                  />
                </div>
              </div>

              {/* Submit */}
              <div className="flex items-end">
                <button
                  type="submit"
                  className="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 dark:bg-blue-700 dark:hover:bg-blue-600"
                >
                  <i className="fas fa-search mr-2"></i>Filter
                </button>
              </div>
            </div>
          </form>
        </div>

        {/* Listings Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {listings.data.length > 0 ? (
            listings.data.map((listing) => (
              <div 
                key={listing.id} 
                className="bg-white dark:bg-zinc-900 rounded-lg shadow-md overflow-hidden hover:shadow-2 hover:-translate-y-1 transition duration-200 relative"
              >
                {/* Listing Image */}
                <div className="h-48 bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center relative">
                  {listing.game.cover_image ? (
                    <img 
                      src={listing.game.cover_image} 
                      alt={listing.title} 
                      className="w-full h-full object-cover" 
                    />
                  ) : (
                    <div className="animate-pulse w-full h-full flex items-center justify-center">
                      <i className="fas fa-image text-6xl text-white opacity-50"></i>
                    </div>
                  )}
                  <span className={`absolute top-2 left-2 px-2 py-1 rounded-full text-xs font-semibold ${
                    listing.type === 'sell' 
                      ? 'bg-green-500 text-white' 
                      : 'bg-blue-500 text-white'
                  }`}>
                    {listing.type === 'sell' ? 'Selling' : 'Buying'}
                  </span>
                </div>
                
                {/* Listing Info */}
                <div className="p-6">
                  <div className="flex items-center justify-between mb-2">
                    <span className="text-sm text-blue-600 dark:text-blue-300 font-semibold">
                      {listing.game.title}
                    </span>
                    <span className={`text-sm font-semibold ${
                      listing.status === 'active' 
                        ? 'text-green-600 dark:text-green-400' 
                        : 'text-gray-500 dark:text-gray-300'
                    }`}>
                      {listing.status}
                    </span>
                  </div>
                  <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-2">
                    {listing.title}
                  </h3>
                  <p className="text-gray-600 dark:text-gray-300 text-sm mb-4">
                    {listing.description.substring(0, 100)}...
                  </p>
                  <div className="flex items-center justify-between">
                    <span className="text-2xl font-bold text-green-600 dark:text-green-400">
                      ${parseFloat(listing.price.toString()).toFixed(2)}
                    </span>
                    <Link 
                      href={route('listings.show', listing.id)}
                      className="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 text-sm dark:bg-blue-700 dark:hover:bg-blue-600"
                    >
                      View Details
                    </Link>
                  </div>
                </div>
              </div>
            ))
          ) : (
            <div className="col-span-full text-center py-12">
              <i className="fas fa-list-alt text-6xl text-gray-300 dark:text-zinc-600 mb-4"></i>
              <h3 className="text-xl font-semibold text-gray-600 dark:text-gray-300 mb-2">
                No listings found
              </h3>
              <p className="text-gray-500 dark:text-gray-400">
                Try adjusting your search criteria
              </p>
            </div>
          )}
        </div>

        {/* Pagination */}
        {listings.meta && listings.meta.links && listings.meta.links.length > 3 && (
          <div className="mt-8">
            <nav className="flex items-center justify-between">
              <div className="flex-1 flex items-center justify-between">
                <div>
                  {listings.meta.links.map((link, index) => (
                    <Link
                      key={index}
                      href={link.url || url}
                      className={`px-4 py-2 mx-1 rounded-md ${
                        link.active
                          ? 'bg-blue-600 text-white'
                          : 'bg-white dark:bg-zinc-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-700'
                      }`}
                      dangerouslySetInnerHTML={{ __html: link.label }}
                    />
                  ))}
                </div>
              </div>
            </nav>
          </div>
        )}
      </div>
    </AppLayout>
  );
}
