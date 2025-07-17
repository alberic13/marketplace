import React from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import Layout from '@/layouts/app-layout';
import { Game, Category, Paginated } from '@/types/index';

interface Props {
  games: Paginated<Game>;
  categories: Category[];
  search: string;
  category: string;
  platform: string;
}

export default function GamesIndex({ games, categories, search, category, platform }: Props) {
  const { url } = usePage();
  
  return (
    <Layout>
      <Head title="Games - GameMarket" />
      
      <div className="max-w-7xl mx-auto px-4 py-8">
        {/* Header */}
        <div className="mb-8">
          <h1 className="text-3xl font-bold text-gray-900 dark:text-white mb-4">Browse Games</h1>
          <p className="text-lg text-gray-600 dark:text-gray-300">
            Discover and explore games available in our marketplace
          </p>
        </div>

        {/* Filters */}
        <div className="bg-white dark:bg-zinc-900 rounded-lg shadow-md p-8 mb-8">
          <form method="GET" action={route('games.index')} className="space-y-4">
            <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
              {/* Search */}
              <div>
                <label htmlFor="search" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                  Search
                </label>
                <input
                  type="text"
                  name="search"
                  id="search"
                  defaultValue={search}
                  placeholder="Search games..."
                  className="w-full px-3 py-2 border border-gray-300 dark:border-zinc-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:text-white"
                />
              </div>

              {/* Category */}
              <div>
                <label htmlFor="category" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                  Category
                </label>
                <select
                  name="category"
                  id="category"
                  defaultValue={category}
                  className="w-full px-3 py-2 border border-gray-300 dark:border-zinc-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:text-white"
                >
                  <option value="">All Categories</option>
                  {categories.map((cat: Category) => (
                    <option key={cat.id} value={cat.slug}>
                      {cat.name}
                    </option>
                  ))}
                </select>
              </div>

              {/* Platform */}
              <div>
                <label htmlFor="platform" className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                  Platform
                </label>
                <select
                  name="platform"
                  id="platform"
                  defaultValue={platform}
                  className="w-full px-3 py-2 border border-gray-300 dark:border-zinc-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:text-white"
                >
                  <option value="">All Platforms</option>
                  <option value="PC">PC</option>
                  <option value="PlayStation">PlayStation</option>
                  <option value="Xbox">Xbox</option>
                  <option value="Nintendo Switch">Nintendo Switch</option>
                  <option value="Mobile">Mobile</option>
                  <option value="Multiple">Multiple</option>
                </select>
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

        {/* Games Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
          {games.data.length > 0 ? (
            games.data.map((game: Game) => (
              <div 
                key={game.id} 
                className="bg-white dark:bg-zinc-900 rounded-lg shadow-md overflow-hidden hover:shadow-2 hover:-translate-y-1 transition duration-200 relative group"
              >
                {/* Game Image */}
                <div className="h-48 bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center relative">
                  {game.cover_image ? (
                    <img 
                      src={game.cover_image} 
                      alt={game.title} 
                      className="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-90" 
                    />
                  ) : (
                    <div className="animate-pulse w-full h-full flex items-center justify-center">
                      <i className="fas fa-gamepad text-6xl text-white opacity-50"></i>
                    </div>
                  )}
                  {game.is_new && (
                    <span className="absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full font-semibold">
                      New
                    </span>
                  )}
                  {game.is_popular && (
                    <span className="absolute top-2 right-2 bg-yellow-400 text-white text-xs px-2 py-1 rounded-full font-semibold">
                      Popular
                    </span>
                  )}
                </div>
                
                {/* Game Info */}
                <div className="p-6">
                  <div className="flex items-center justify-between mb-2">
                    <span className="text-sm text-blue-600 dark:text-blue-300 font-semibold">
                      {game.category.name}
                    </span>
                    <span className="text-sm text-gray-500 dark:text-gray-300">
                      {game.platform}
                    </span>
                  </div>
                  <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-2">
                    {game.title}
                  </h3>
                  {game.developer && (
                    <p className="text-sm text-gray-600 dark:text-gray-300 mb-2">
                      <i className="fas fa-user-cog mr-1"></i>{game.developer}
                    </p>
                  )}
                  <p className="text-gray-600 dark:text-gray-300 text-sm mb-4">
                    {game.description.substring(0, 100)}...
                  </p>
                  <div className="flex items-center justify-between">
                    {game.base_price ? (
                      <span className="text-2xl font-bold text-green-600 dark:text-green-400">
                        ${parseFloat(game.base_price.toString()).toFixed(2)}
                      </span>
                    ) : (
                      <span className="text-sm text-gray-500 dark:text-gray-300">Price varies</span>
                    )}
                    <Link 
                      href={route('games.show', game.id)}
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
              <i className="fas fa-gamepad text-6xl text-gray-300 dark:text-zinc-600 mb-4"></i>
              <h3 className="text-xl font-semibold text-gray-600 dark:text-gray-300 mb-2">
                No games found
              </h3>
              <p className="text-gray-500 dark:text-gray-400">
                Try adjusting your search criteria
              </p>
            </div>
          )}
        </div>

        {/* Pagination */}
        {games.meta && games.meta.links && games.meta.links.length > 3 && (
          <div className="mt-8">
            <nav className="flex items-center justify-between">
              <div className="flex-1 flex items-center justify-between">
                <div>
                  {games.meta.links.map((link: any, index: number) => (
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
    </Layout>
  );
}
