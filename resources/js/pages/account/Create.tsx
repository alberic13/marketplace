import React from 'react';
import { Head } from '@inertiajs/react';
import Layout from '@/layouts/app-layout';

export default function AccountCreate() {
    return (
        <Layout>
            <Head title="Create Account" />
            <div className="container mx-auto px-6 py-8">
                <h1 className="text-3xl font-bold text-gray-800 mb-6">Create Account</h1>
                {/* Add account creation form here */}
            </div>
        </Layout>
    );
}
