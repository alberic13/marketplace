import React from 'react';
import { Head, usePage } from '@inertiajs/react';
import Layout from '@/layouts/app-layout';
import { Category, Game, Listing } from '@/types/index';

interface Props {
  categories: Category[];
  featuredGames: Game[];
  recentListings: Listing[];
}

export default function Home({ categories, featuredGames, recentListings }: Props) {
  const { auth } = usePage().props as any;
  return (
    <Layout>
      <Head title="Home" />
      
      {/* Hero Section with SVG Wave */}
      <div className="relative bg-gradient-to-r from-blue-600 to-purple-600 dark:from-zinc-900 dark:to-zinc-800 text-white overflow-hidden w-full">
        <div className="w-full px-4 py-24 md:px-8">
          <div className="text-center">
            <h1 className="text-4xl md:text-6xl font-bold mb-6 drop-shadow-lg">
              Welcome to GameMarket
            </h1>
            <p className="text-xl md:text-2xl mb-8 opacity-90">
              Your ultimate destination for buying and selling games
            </p>
            <div className="space-x-4">
              <a href={route('listings.index')} className="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-100 shadow-lg transition duration-200">
                Browse Listings
              </a>
              {!auth.user ? (
                <a href={route('register')} className="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 shadow-lg transition duration-200">
                  Join Now
                </a>
              ) : (
                <a href={route('my-listings.create')} className="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 shadow-lg transition duration-200">
                  Sell Your Game
                </a>
              )}
            </div>
          </div>
        </div>
        {/* SVG Wave */}
        <svg className="absolute bottom-0 left-0 w-full" height="80" viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill="#f3f4f6" fillOpacity="1" d="M0,32L48,37.3C96,43,192,53,288,58.7C384,64,480,64,576,53.3C672,43,768,21,864,16C960,11,1056,21,1152,32C1248,43,1344,53,1392,58.7L1440,64L1440,80L1392,80C1344,80,1248,80,1152,80C1056,80,960,80,864,80C768,80,672,80,576,80C480,80,384,80,288,80C192,80,96,80,48,80L0,80Z"></path>
        </svg>
      </div>

      {!auth.user && (
        <div className="bg-gradient-to-r from-green-500 to-blue-600 text-white py-16">
          <div className="max-w-4xl mx-auto px-4 text-center">
            <div className="mb-8">
              <h2 className="text-3xl md:text-4xl font-bold mb-4">Ready to Start Selling?</h2>
              <p className="text-xl opacity-90 mb-8">
                Join thousands of gamers buying and selling on GameMarket. 
                Create your free account and start listing your games today!
              </p>
            </div>
            
            <div className="grid md:grid-cols-3 gap-8 mb-8">
              <div className="text-center">
                <div className="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                  <span className="text-2xl">📝</span>
                </div>
                <h3 className="text-lg font-semibold mb-2">Create Listings</h3>
                <p className="text-sm opacity-80">List your games with photos and descriptions</p>
              </div>
              <div className="text-center">
                <div className="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                  <span className="text-2xl">💬</span>
                </div>
                <h3 className="text-lg font-semibold mb-2">Connect Safely</h3>
                <p className="text-sm opacity-80">Message buyers and sellers securely</p>
              </div>
              <div className="text-center">
                <div className="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                  <span className="text-2xl">💰</span>
                </div>
                <h3 className="text-lg font-semibold mb-2">Earn Money</h3>
                <p className="text-sm opacity-80">Turn your unused games into cash</p>
              </div>
            </div>
            
            <div className="space-x-4">
              <a href={route('register')} className="bg-white text-green-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition duration-200 inline-block">
                Create Free Account
              </a>
              <a href={route('listings.index')} className="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-green-600 transition duration-200 inline-block">
                Browse First
              </a>
            </div>
          </div>
        </div>
      )}

      {/* Categories Section with Icons */}
      <div className="w-full px-4 py-16 md:px-8 bg-background dark:bg-[#18181b]">
        <div className="text-center mb-12">
          <h2 className="text-3xl font-bold text-gray-900 dark:text-white mb-4">Browse by Category</h2>
          <p className="text-lg text-gray-600 dark:text-gray-300">Discover games from your favorite genres</p>
        </div>
        <div className="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6">
          {categories.map((category) => (
            <a key={category.id} href={route('categories.show', { category: category.id })} className="group">
              <div className="bg-white dark:bg-zinc-900 rounded-lg shadow-md p-6 text-center hover:shadow-2 hover:-translate-y-1 transition duration-200 transform group-hover:scale-105">
                <div className="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-200 transition duration-200">
                  <i className={`fas fa-${category.icon || 'gamepad'} text-2xl text-blue-600 dark:text-blue-300`}></i>
                </div>
                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">{category.name}</h3>
                <p className="text-sm text-gray-600 dark:text-gray-300">{category.description.substring(0, 50)}</p>
              </div>
            </a>
          ))}
        </div>
        <div className="text-center mt-8">
          <a href={route('categories.index')} className="text-blue-600 dark:text-blue-300 hover:text-blue-800 font-semibold">
            View All Categories <i className="fas fa-arrow-right ml-1"></i>
          </a>
        </div>
      </div>

      {/* Featured Games Section */}
      <div className="bg-gray-50 dark:bg-zinc-800 py-16 w-full px-4 md:px-8">
        <div className="text-center mb-12">
          <h2 className="text-3xl font-bold text-gray-900 dark:text-white mb-4">Featured Games</h2>
          <p className="text-lg text-gray-600 dark:text-gray-300">Popular games in our marketplace</p>
        </div>
        
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {featuredGames.map((game) => (
            <div key={game.id} className="bg-white dark:bg-zinc-900 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
              <div className="h-48 bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                {game.cover_image ? (
                  <img src={game.cover_image} alt={game.title} className="w-full h-full object-cover" />
                ) : (
                  <i className="fas fa-gamepad text-6xl text-white opacity-50"></i>
                )}
              </div>
              <div className="p-6">
                <div className="flex items-center justify-between mb-2">
                  <span className="text-sm text-blue-600 dark:text-blue-300 font-semibold">{game.category.name}</span>
                  <span className="text-sm text-gray-500 dark:text-gray-300">{game.platform}</span>
                </div>
                <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-2">{game.title}</h3>
                <p className="text-gray-600 dark:text-gray-300 text-sm mb-4">{game.description.substring(0, 100)}</p>
                <div className="flex items-center justify-between">
                {game.base_price ? (
                  <span className="text-2xl font-bold text-green-600 dark:text-green-400">${parseFloat(String(game.base_price)).toFixed(2)}</span>
                ) : (
                  <span className="text-sm text-gray-500 dark:text-gray-300">Price not available</span>
                )}
                  <a href={route('games.show', { game: game.id })} className="text-blue-600 dark:text-blue-300 hover:text-blue-800 font-semibold">
                    View Details <i className="fas fa-arrow-right ml-1"></i>
                  </a>
                </div>
              </div>
            </div>
          ))}
        </div>
        
        <div className="text-center mt-8">
          <a href={route('games.index')} className="text-blue-600 dark:text-blue-300 hover:text-blue-800 font-semibold">
            View All Games <i className="fas fa-arrow-right ml-1"></i>
          </a>
        </div>
      </div>

      {/* Recent Listings Section */}
      <div className="w-full px-4 py-16 md:px-8 bg-background dark:bg-[#18181b]">
        <div className="text-center mb-12">
          <h2 className="text-3xl font-bold text-gray-900 dark:text-white mb-4">Recent Listings</h2>
          <p className="text-lg text-gray-600 dark:text-gray-300">Latest games available for sale</p>
        </div>
        
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          {recentListings.map((listing) => (
            <div key={listing.id} className="bg-white dark:bg-zinc-900 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
              <div className="h-32 bg-gradient-to-r from-green-400 to-blue-500 flex items-center justify-center">
                <i className="fas fa-gamepad text-3xl text-white opacity-50"></i>
              </div>
              <div className="p-4">
                <div className="flex items-center justify-between mb-2">
                  <span className={`text-xs bg-${listing.type === 'sell' ? 'green' : 'blue'}-100 text-${listing.type === 'sell' ? 'green' : 'blue'}-800 dark:bg-${listing.type === 'sell' ? 'green' : 'blue'}-900 dark:text-${listing.type === 'sell' ? 'green' : 'blue'}-300 px-2 py-1 rounded-full font-semibold`}>
                    {listing.type.charAt(0).toUpperCase() + listing.type.slice(1)}
                  </span>
                  <span className="text-xs text-gray-500 dark:text-gray-300">{listing.condition.charAt(0).toUpperCase() + listing.condition.slice(1)}</span>
                </div>
                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-1">{listing.title.substring(0, 30)}</h3>
                <p className="text-sm text-gray-600 dark:text-gray-300 mb-2">{listing.game.title}</p>
                <div className="flex items-center justify-between">
                  <span className="text-xl font-bold text-green-600 dark:text-green-400">${parseFloat(String(listing.price)).toFixed(2)}</span>
                  <a href={route('listings.show', { listing: listing.id })} className="text-blue-600 dark:text-blue-300 hover:text-blue-800 text-sm font-semibold">
                    View <i className="fas fa-arrow-right ml-1"></i>
                  </a>
                </div>
              </div>
            </div>
          ))}
        </div>
        
        <div className="text-center mt-8">
          <a href={route('listings.index')} className="text-blue-600 dark:text-blue-300 hover:text-blue-800 font-semibold">
            View All Listings <i className="fas fa-arrow-right ml-1"></i>
          </a>
        </div>
      </div>

      {/* Call to Action Section */}
      <div className="bg-blue-600 dark:bg-blue-900 text-white py-16 w-full px-4 md:px-8">
        <div className="text-center">
          <h2 className="text-3xl font-bold mb-4">Ready to Start Trading?</h2>
          <p className="text-xl mb-8 opacity-90">Join thousands of gamers buying and selling games on our platform</p>
          <div className="space-x-4">
            {auth.user ? (
              <a href={route('my-listings.create')} className="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-200">
                Create Your First Listing
              </a>
            ) : (
              <>
                <a href={route('register')} className="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-200">
                  Sign Up Now
                </a>
                <a href={route('login')} className="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition duration-200">
                  Already a Member?
                </a>
              </>
            )}
          </div>
        </div>
      </div>

      {/* Testimonials/Trust Section */}
      <div className="bg-white dark:bg-zinc-900 py-16 w-full px-4 md:px-8">
        <div className="text-center">
          <h2 className="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Trusted by Gamers Everywhere</h2>
          <div className="flex flex-col md:flex-row justify-center gap-8">
            <div className="bg-gray-50 dark:bg-zinc-800 rounded-lg p-6 shadow-md flex-1">
              <div className="text-3xl mb-2">⭐️⭐️⭐️⭐️⭐️</div>
              <p className="text-gray-700 dark:text-gray-200 mb-2">“GameMarket made it so easy to sell my old games. I got paid fast and met awesome buyers!”</p>
              <div className="text-sm text-gray-500 dark:text-gray-300">— Alex, Seller</div>
            </div>
            <div className="bg-gray-50 dark:bg-zinc-800 rounded-lg p-6 shadow-md flex-1">
              <div className="text-3xl mb-2">⭐️⭐️⭐️⭐️⭐️</div>
              <p className="text-gray-700 dark:text-gray-200 mb-2">“I found rare games at great prices. The checkout was smooth and secure!”</p>
              <div className="text-sm text-gray-500 dark:text-gray-300">— Jamie, Buyer</div>
            </div>
          </div>
          <div className="mt-8 flex justify-center gap-6">
            <img src="/build/assets/app-logo-icon-Bqx0jWkV.svg" alt="Secure" className="h-10 inline-block" />
            <span className="text-green-600 dark:text-green-400 font-semibold flex items-center"><i className="fas fa-shield-alt mr-2"></i> Buyer Protection</span>
            <span className="text-blue-600 dark:text-blue-300 font-semibold flex items-center"><i className="fas fa-lock mr-2"></i> Secure Payments</span>
          </div>
        </div>
      </div>
    </Layout>
  );
}
