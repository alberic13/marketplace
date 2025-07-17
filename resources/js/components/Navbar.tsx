import React from 'react';
import { Link } from '@inertiajs/react';

const Navbar: React.FC = () => {
  return (
    <nav className="bg-gray-800 text-white p-4">
      <div className="container mx-auto flex justify-between items-center">
        <div className="text-xl font-bold">
          <Link href="/">Marketplace</Link>
        </div>
        <div className="space-x-4">
          <Link href="/" className="hover:text-gray-300">Home</Link>
          <Link href="/games" className="hover:text-gray-300">Games</Link>
          <Link href="/listings" className="hover:text-gray-300">Listings</Link>
          <Link href="/categories" className="hover:text-gray-300">Categories</Link>
          <Link href="/cart" className="hover:text-gray-300">Cart</Link>
          <Link href="/profile" className="hover:text-gray-300">Profile</Link>
        </div>
      </div>
    </nav>
  );
};

export default Navbar;
