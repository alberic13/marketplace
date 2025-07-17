import React from 'react';
import { Head } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';

const Profile = () => {
  return (
    <MainLayout>
      <Head title="Profile" />
      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 bg-white border-b border-gray-200">
              <h1 className="text-2xl font-bold mb-4">User Profile</h1>
              <p>This is your profile page.</p>
            </div>
          </div>
        </div>
      </div>
    </MainLayout>
  );
};

export default Profile;
