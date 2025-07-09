import '../css/app.css';

import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';
<<<<<<< HEAD
import { ThemeProvider } from './components/theme-provider';
=======
import { initializeTheme } from './hooks/use-appearance';
>>>>>>> 7e327ca25780d6043a71a16d2ba1e325c59e1d84

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./pages/${name}.tsx`, import.meta.glob('./pages/**/*.tsx')),
    setup({ el, App, props }) {
        const root = createRoot(el);

<<<<<<< HEAD
        root.render(
            <ThemeProvider defaultTheme="system" storageKey="marketplace-theme">
                <App {...props} />
            </ThemeProvider>
        );
=======
        root.render(<App {...props} />);
>>>>>>> 7e327ca25780d6043a71a16d2ba1e325c59e1d84
    },
    progress: {
        color: '#4B5563',
    },
});
<<<<<<< HEAD
=======

// This will set light / dark mode on load...
initializeTheme();
>>>>>>> 7e327ca25780d6043a71a16d2ba1e325c59e1d84
