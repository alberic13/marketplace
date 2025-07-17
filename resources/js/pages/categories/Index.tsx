import React from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { Category, Paginated } from '@/types/index';

interface Props {
  categories: Paginated<Category>;
}

export default function CategoriesIndex({ categories }: Props) {
  const { url } = usePage();
  
  return (
    <AppLayout>
      <Head title="Categories - GameMarket" />
      
      <div className="max-w-7xl mx-auto px-4 py-8">
        {/* Header */}
        <div className="mb-8">
          <h1 className="text-3xl font-bold text-gray-900 dark:text-white mb-4">Browse Categories</h1>
          <p className="text-lg text-gray-600 dark:text-gray-300">
            Explore games by category
          </p>
        </div>

        {/* Categories Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {categories.data.length > 0 ? (
            categories.data.map((category) => (
              <div 
                key={category.id} 
                className="bg-white dark:bg-zinc-900 rounded-lg shadow-md overflow-hidden hover:shadow-2 hover:-translate-y-1 transition duration-200"
              >
                {/* Category Image */}
                <div className="h-48 bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                  {category.image ? (
                    <img 
                      src={category.image} 
                      alt={category.name} 
                      className="w-full h-full object-cover" 
                    />
                  ) : (
                    <div className="animate-pulse w-full h-full flex items-center justify-center">
                      <i className="fas fa-folder text-6xl text-white opacity-50"></i>
                    </div>
                  )}
                </div>
                
                {/* Category Info */}
                <div className="p-6">
                  <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-2">
                    {category.name}
                  </h3>
                  <p className="text-gray-600 dark:text-gray-300 text-sm mb-4">
                    {category.description?.substring(0, 100)}...
                  </p>
                  <div className="flex items-center justify-between">
                    <span className="text-sm text-gray-500 dark:text-gray-300">
                      {category.games_count} games
                    </span>
                    <Link 
                      href={route('categories.show', category.slug)}
                      className="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 text-sm dark:bg-blue-700 dark:hover:bg-blue-600"
                    >
                      Browse Games
                    </Link>
                  </div>
                </div>
              </div>
            ))
          ) : (
            <div className="col-span-full text-center py-12">
              <i className="fas fa-folder-open text-6xl text-gray-300 dark:text-zinc-600 mb-4"></i>
              <h3 className="text-xl font-semibold text-gray-600 dark:text-gray-300 mb-2">
                No categories found
              </h3>
              <p className="text-gray-500 dark:text-gray-400">
                Try again later
              </p>
            </div>
          )}
        </div>

        {/* Pagination */}
        {categories.meta && categories.meta.links && categories.meta.links.length > 3 && (
          <div className="mt-8">
            <nav className="flex items-center justify-between">
              <div className="flex-1 flex items-center justify-between">
                <div>
                  {categories.meta.links.map((link, index) => (
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
