import React from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { Game, Paginated, Listing } from '@/types/index';

interface Props {
  game: Game;
  listings: Paginated<Listing>;
}

export default function GamesShow({ game, listings }: Props) {
  const { url } = usePage();
  
  return (
    <AppLayout>
      <Head title={`${game.title} - GameMarket`} />
      
      <div className="max-w-7xl mx-auto px-4 py-8">
        {/* Game Header */}
        <div className="mb-8">
          <div className="flex items-center mb-4">
            <Link href={route('games.index')} className="text-blue-600 hover:text-blue-800 dark:text-blue-300 dark:hover:text-blue-200">
              Games
            </Link>
            <span className="mx-2 text-gray-500">/</span>
            <Link href={route('categories.show', game.category.slug)} className="text-blue-600 hover:text-blue-800 dark:text-blue-300 dark:hover:text-blue-200">
              {game.category.name}
            </Link>
            <span className="mx-2 text-gray-500">/</span>
            <h1 className="text-3xl font-bold text-gray-900 dark:text-white">{game.title}</h1>
          </div>
          
          <div className="flex flex-col md:flex-row gap-8">
            {/* Game Cover Image */}
            <div className="md:w-1/3">
              {game.cover_image ? (
                <img 
                  src={game.cover_image} 
                  alt={game.title} 
                  className="w-full rounded-lg shadow-md" 
                />
              ) : (
                <div className="bg-gray-200 dark:bg-zinc-800 border-2 border-dashed rounded-xl w-full h-64 flex items-center justify-center">
                  <i className="fas fa-gamepad text-6xl text-gray-400"></i>
                </div>
              )}
            </div>
            
            {/* Game Details */}
            <div className="md:w-2/3">
              <p className="text-lg text-gray-600 dark:text-gray-300 mb-6">
                {game.description}
              </p>
              
              <div className="grid grid-cols-2 gap-4 mb-6">
                <div>
                  <h3 className="text-sm font-medium text-gray-500 dark:text-gray-400">Platform</h3>
                  <p className="text-lg font-medium text-gray-900 dark:text-white">{game.platform}</p>
                </div>
                <div>
                  <h3 className="text-sm font-medium text-gray-500 dark:text-gray-400">Developer</h3>
                  <p className="text-lg font-medium text-gray-900 dark:text-white">{game.developer || 'Unknown'}</p>
                </div>
                <div>
                  <h3 className="text-sm font-medium text-gray-500 dark:text-gray-400">Base Price</h3>
                  <p className="text-lg font-medium text-gray-900 dark:text-white">${parseFloat(game.base_price.toString()).toFixed(2)}</p>
                </div>
                <div>
                  <h3 className="text-sm font-medium text-gray-500 dark:text-gray-400">Listings</h3>
                  <p className="text-lg font-medium text-gray-900 dark:text-white">{listings?.meta?.total || 0}</p>
                </div>
              </div>
              
              <div className="flex space-x-4">
                <button className="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition duration-200 dark:bg-blue-700 dark:hover:bg-blue-600">
                  <i className="fas fa-shopping-cart mr-2"></i>Add to Cart
                </button>
                <button className="bg-gray-200 text-gray-800 px-6 py-3 rounded-md hover:bg-gray-300 transition duration-200 dark:bg-zinc-700 dark:text-white dark:hover:bg-zinc-600">
                  <i className="fas fa-heart mr-2"></i>Add to Wishlist
                </button>
              </div>
            </div>
          </div>
        </div>

        {/* Listings Section */}
        <div className="mb-12">
          <h2 className="text-2xl font-bold text-gray-900 dark:text-white mb-6">Listings for {game.title}</h2>
          
          <div className="bg-white dark:bg-zinc-900 rounded-lg shadow-md p-6 mb-6">
            <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
              {/* Filters would go here */}
            </div>
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
                    <span className={`absolute top-2 left-2 px-2 py-1 rounded-full text-xs font-semibold ${listing.type === 'sell' ? 'bg-green-500 text-white' : 'bg-blue-500 text-white'}`}>
                      {listing.type === 'sell' ? 'Selling' : 'Buying'}
                    </span>
                  </div>
                  
                  {/* Listing Info */}
                  <div className="p-6">
                    <div className="flex items-center justify-between mb-2">
                      <span className="text-sm text-blue-600 dark:text-blue-300 font-semibold">
                        {listing.user.name}
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
                  No listings found for this game
                </h3>
                <p className="text-gray-500 dark:text-gray-400">
                  Be the first to create a listing
                </p>
              </div>
            )}
          </div>
          
          {/* Pagination */}
          {listings?.meta?.links && listings.meta.links.length > 3 && (
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
      </div>
    </AppLayout>
  );
}
