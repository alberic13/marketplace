import React, { useState } from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { Category, Game, Listing } from '@/types/index';

interface Props {
  category: Category;
  games: Game[];
  listings: Paginated<Listing>;
  totalListings: number;
}

export default function CategoriesShow({ category, games, listings, totalListings }: Props) {
  const { url } = usePage();
  const [activeTab, setActiveTab] = useState('listings');
  
  return (
    <AppLayout>
      <Head title={`${category.name} - GameMarket`} />
      
      <div className="max-w-7xl mx-auto px-4 py-8">
        {/* Category Header */}
        <div className="mb-8">
          <div className="flex items-center mb-4">
            <Link href={route('categories.index')} className="text-blue-600 hover:text-blue-800 dark:text-blue-300 dark:hover:text-blue-200">
              Categories
            </Link>
            <span className="mx-2 text-gray-500">/</span>
            <h1 className="text-3xl font-bold text-gray-900 dark:text-white">{category.name}</h1>
          </div>
          <p className="text-lg text-gray-600 dark:text-gray-300">
            {category.description}
          </p>
        </div>

        {/* Tabs */}
        <div className="border-b border-gray-200 dark:border-zinc-700 mb-6">
          <nav className="flex space-x-8">
            <button
              onClick={() => setActiveTab('listings')}
              className={`py-4 px-1 border-b-2 font-medium text-sm ${
                activeTab === 'listings'
                  ? 'border-blue-500 text-blue-600 dark:border-blue-400 dark:text-blue-300'
                  : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-400'
              }`}
            >
              Listings ({totalListings})
            </button>
            <button
              onClick={() => setActiveTab('games')}
              className={`py-4 px-1 border-b-2 font-medium text-sm ${
                activeTab === 'games'
                  ? 'border-blue-500 text-blue-600 dark:border-blue-400 dark:text-blue-300'
                  : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-400'
              }`}
            >
              Games ({category.games_count})
            </button>
          </nav>
        </div>

        {/* Tab Content */}
        {activeTab === 'listings' ? (
          <div>
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
                      <span className={`absolute top-2 left-2 px-2 py-1 rounded-full text-xs font-semibold ${listing.type === 'sell' ? 'bg-green-500 text-white' : 'bg-blue-500 text-white'}`}>
                        {listing.type === 'sell' ? 'Selling' : 'Buying'}
                      </span>
                    </div>
                    
                    {/* Listing Info */}
                    <div className="p-6">
                      <div className="flex items-center justify-between mb-2">
                        <span className="text-sm text-blue-600 dark:text-blue-300 font-semibold">
                          {listing.game.title}
                        </span>
                        <span className={`text-sm font-semibold ${listing.status === 'active' ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-300'}`}>
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
                    No listings found in this category
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
        ) : (
          <div>
            {/* Games Grid */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
              {games.length > 0 ? (
                games.map((game) => (
                  <div 
                    key={game.id} 
                    className="bg-white dark:bg-zinc-900 rounded-lg shadow-md overflow-hidden hover:shadow-2 hover:-translate-y-1 transition duration-200"
                  >
                    {/* Game Image */}
                    <div className="h-48 bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                      {game.cover_image ? (
                        <img 
                          src={game.cover_image} 
                          alt={game.title} 
                          className="w-full h-full object-cover" 
                        />
                      ) : (
                        <div className="animate-pulse w-full h-full flex items-center justify-center">
                          <i className="fas fa-gamepad text-6xl text-white opacity-50"></i>
                        </div>
                      )}
                    </div>
                    
                    {/* Game Info */}
                    <div className="p-6">
                      <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-2">
                        {game.title}
                      </h3>
                      <p className="text-gray-600 dark:text-gray-300 text-sm mb-4">
                        {game.description.substring(0, 100)}...
                      </p>
                      <div className="flex items-center justify-between">
                        <span className="text-sm text-gray-500 dark:text-gray-300">
                          {game.listings_count} listings
                        </span>
                        <Link 
                          href={route('games.show', game.slug)}
                          className="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 text-sm dark:bg-blue-700 dark:hover:bg-blue-600"
                        >
                          View Listings
                        </Link>
                      </div>
                    </div>
                  </div>
                ))
              ) : (
                <div className="col-span-full text-center py-12">
                  <i className="fas fa-gamepad text-6xl text-gray-300 dark:text-zinc-600 mb-4"></i>
                  <h3 className="text-xl font-semibold text-gray-600 dark:text-gray-300 mb-2">
                    No games found in this category
                  </h3>
                  <p className="text-gray-500 dark:text-gray-400">
                    Try again later
                  </p>
                </div>
              )}
            </div>
          </div>
        )}
      </div>
    </AppLayout>
  );
}
