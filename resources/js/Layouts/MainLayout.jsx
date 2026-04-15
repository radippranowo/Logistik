import React from 'react';

export default function MainLayout({ children }) {
    return (
        <div style={{ padding: '20px', background: '#f4f4f4', minHeight: '100vh' }}>
            <nav style={{ marginBottom: '20px', borderBottom: '1px solid #ccc' }}>
                <strong>TEST NAV SKOTE</strong>
            </nav>
            <main>
                {children}
            </main>
        </div>
    );
}