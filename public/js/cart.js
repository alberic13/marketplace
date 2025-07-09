// Shopping Cart JavaScript functionality
document.addEventListener('DOMContentLoaded', function() {
    // Handle quantity updates
    const quantityInputs = document.querySelectorAll('.quantity-input');
    
    quantityInputs.forEach(input => {
        let timeout;
        
        input.addEventListener('change', function() {
            clearTimeout(timeout);
            const form = this.closest('form');
            const button = this;
            
            // Show updating state
            button.style.opacity = '0.6';
            button.disabled = true;
            
            // Debounce the update
            timeout = setTimeout(() => {
                updateQuantity(form, button);
            }, 500);
        });
    });
    
    function updateQuantity(form, button) {
        const formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => {
            if (response.ok) {
                // Reload the page to show updated totals
                location.reload();
            } else {
                throw new Error('Failed to update quantity');
            }
        })
        .catch(error => {
            console.error('Error updating quantity:', error);
            showNotification('Failed to update quantity. Please try again.', 'error');
            
            // Reset button state
            button.style.opacity = '1';
            button.disabled = false;
        });
    }
    
    // Handle remove items with confirmation
    const removeButtons = document.querySelectorAll('.remove-item');
    
    removeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (confirm('Are you sure you want to remove this item from your cart?')) {
                const form = this.closest('form');
                
                // Show loading state
                this.textContent = 'Removing...';
                this.disabled = true;
                
                form.submit();
            }
        });
    });
    
    // Handle clear cart with confirmation
    const clearCartButton = document.querySelector('.clear-cart');
    
    if (clearCartButton) {
        clearCartButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (confirm('Are you sure you want to clear your entire cart? This action cannot be undone.')) {
                const form = this.closest('form');
                
                // Show loading state
                this.textContent = 'Clearing...';
                this.disabled = true;
                
                form.submit();
            }
        });
    }
    
    // Enhanced notification system
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.toast-notification');
        existingNotifications.forEach(notification => {
            notification.remove();
        });
        
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `toast-notification fixed top-4 right-4 px-6 py-4 rounded-lg shadow-lg z-50 transform transition-all duration-300 translate-y-0 ${getNotificationColor(type)}`;
        notification.innerHTML = `
            <div class="flex items-center">
                <span class="mr-3">${getNotificationIcon(type)}</span>
                <span>${message}</span>
                <button class="ml-4 text-white hover:text-gray-200" onclick="this.parentElement.parentElement.remove()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        `;
        
        // Add to page
        document.body.appendChild(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.style.transform = 'translateY(-100%)';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }
        }, 5000);
    }
    
    function getNotificationColor(type) {
        switch (type) {
            case 'success':
                return 'bg-green-500 text-white';
            case 'error':
                return 'bg-red-500 text-white';
            case 'warning':
                return 'bg-yellow-500 text-white';
            default:
                return 'bg-blue-500 text-white';
        }
    }
    
    function getNotificationIcon(type) {
        switch (type) {
            case 'success':
                return '✅';
            case 'error':
                return '❌';
            case 'warning':
                return '⚠️';
            default:
                return 'ℹ️';
        }
    }
    
    // Update cart count in navbar
    function updateCartCount() {
        fetch('/cart/count')
            .then(response => response.json())
            .then(data => {
                const cartBadge = document.querySelector('.cart-count');
                if (cartBadge) {
                    cartBadge.textContent = data.count;
                    cartBadge.style.display = data.count > 0 ? 'inline' : 'none';
                }
            })
            .catch(error => console.error('Error updating cart count:', error));
    }
    
    // Initialize cart count
    updateCartCount();
});
