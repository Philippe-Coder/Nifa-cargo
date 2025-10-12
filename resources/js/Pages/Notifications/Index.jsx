import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { formatDistanceToNow } from 'date-fns';
import { fr } from 'date-fns/locale';

export default function NotificationsIndex({ notifications }) {
    return (
        <AuthenticatedLayout
            header={
                <div className="flex justify-between items-center">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        Mes Notifications
                    </h2>
                    <div className="flex space-x-2">
                        <Link
                            href={route('notifications.markAllRead')}
                            method="post"
                            as="button"
                            className="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            Tout marquer comme lu
                        </Link>
                    </div>
                </div>
            }
        >
            <Head title="Mes Notifications" />

            <div className="py-6">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">
                            {notifications.data.length === 0 ? (
                                <div className="text-center py-12">
                                    <svg
                                        className="mx-auto h-12 w-12 text-gray-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        aria-hidden="true"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth="1"
                                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                                        />
                                    </svg>
                                    <h3 className="mt-2 text-sm font-medium text-gray-900">
                                        Aucune notification
                                    </h3>
                                    <p className="mt-1 text-sm text-gray-500">
                                        Vous n'avez pas encore de notifications.
                                    </p>
                                </div>
                            ) : (
                                <div className="flow-root">
                                    <ul role="list" className="divide-y divide-gray-200">
                                        {notifications.data.map((notification) => (
                                            <li key={notification.id} className="py-4">
                                                <Link
                                                    href={notification.url}
                                                    className="block hover:bg-gray-50 px-4 py-2 rounded-lg transition-colors duration-150"
                                                >
                                                    <div className="flex items-center">
                                                        <div className="flex-shrink-0">
                                                            <span className="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                                <svg
                                                                    className="h-5 w-5 text-blue-500"
                                                                    fill="none"
                                                                    viewBox="0 0 24 24"
                                                                    stroke="currentColor"
                                                                >
                                                                    <path
                                                                        strokeLinecap="round"
                                                                        strokeLinejoin="round"
                                                                        strokeWidth="1.5"
                                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                                                    />
                                                                </svg>
                                                            </span>
                                                        </div>
                                                        <div className="ml-3 flex-1 min-w-0">
                                                            <p className="text-sm font-medium text-gray-900 truncate">
                                                                {notification.message}
                                                            </p>
                                                            <p className="text-sm text-gray-500">
                                                                {formatDistanceToNow(new Date(notification.created_at), {
                                                                    addSuffix: true,
                                                                    locale: fr,
                                                                })}
                                                            </p>
                                                        </div>
                                                        {!notification.read_at && (
                                                            <div className="ml-2 flex-shrink-0">
                                                                <span className="h-2 w-2 rounded-full bg-blue-500"></span>
                                                            </div>
                                                        )}
                                                    </div>
                                                </Link>
                                            </li>
                                        ))}
                                    </ul>
                                </div>
                            )}

                            {notifications.links && (
                                <div className="mt-6">
                                    <nav
                                        className="flex items-center justify-between border-t border-gray-200 px-4 sm:px-0"
                                        aria-label="Pagination"
                                    >
                                        <div className="-mt-px flex-1 flex justify-between sm:justify-end">
                                            {notifications.prev_page_url && (
                                                <Link
                                                    href={notifications.prev_page_url}
                                                    className="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                                >
                                                    Précédent
                                                </Link>
                                            )}
                                            {notifications.next_page_url && (
                                                <Link
                                                    href={notifications.next_page_url}
                                                    className="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                                >
                                                    Suivant
                                                </Link>
                                            )}
                                        </div>
                                    </nav>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
