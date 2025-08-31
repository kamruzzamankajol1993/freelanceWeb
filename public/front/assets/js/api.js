// Simple API helper for frontend-backend integration
// Stores anonymous cart session in localStorage and sends X-Session-Id header

(function (global) {
  const API_BASE_URL = '/api';
  const SESSION_STORAGE_KEY = 'session_id';

  function getSessionIdFromStorage() {
    try {
      return localStorage.getItem(SESSION_STORAGE_KEY) || '';
    } catch (_) {
      return '';
    }
  }

  function saveSessionId(sessionId) {
    if (!sessionId) return;
    try {
      localStorage.setItem(SESSION_STORAGE_KEY, sessionId);
    } catch (_) {}
  }

  async function apiRequest(path, options = {}) {
    const headers = options.headers || {};
    const sessionId = getSessionIdFromStorage();
    const url = `${API_BASE_URL}${path}`;

    const finalHeaders = {
      'Content-Type': 'application/json',
      ...(sessionId ? { 'X-Session-Id': sessionId } : {}),
      ...headers,
    };

    console.log('API Request:', {
      url,
      method: options.method || 'GET',
      headers: finalHeaders,
      body: options.body
    });

    try {
      const res = await fetch(url, {
        credentials: 'include',
        ...options,
        headers: finalHeaders,
      });

      console.log('API Response:', {
        status: res.status,
        statusText: res.statusText,
        headers: Object.fromEntries(res.headers.entries())
      });

      const isJson = (res.headers.get('content-type') || '').includes('application/json');
      const data = isJson ? await res.json() : null;

      console.log('API Response data:', data);

      // Capture session id if backend returns it
      if (data && typeof data === 'object' && data.session_id) {
        saveSessionId(data.session_id);
      }

      if (!res.ok) {
        const message = (data && (data.message || data.error)) || `Request failed with ${res.status}`;
        throw new Error(message);
      }

      return data;
    } catch (error) {
      console.error('API Request failed:', error);
      throw error;
    }
  }

  // Products
  async function fetchProducts() {
    const data = await apiRequest('/products', { method: 'GET' });
    return data;
  }

  async function fetchProductBySlug(slug) {
    const data = await apiRequest(`/products/${encodeURIComponent(slug)}`, { method: 'GET' });
    return data;
  }

  // Cart
  async function getCart() {
    try {
      console.log('Getting cart...');
      const data = await apiRequest('/cart', { method: 'GET' });
      console.log('Cart response:', data);
      return data;
    } catch (error) {
      console.error('Error getting cart:', error);
      throw error;
    }
  }

  async function addToCart(productId, quantity = 1) {
    console.log('Adding to cart:', productId, quantity);
    try {
      const data = await apiRequest('/cart', {
        method: 'POST',
        body: JSON.stringify({ product_id: productId, quantity }),
      });
      console.log('Add to cart success:', data);
      return data;
    } catch (error) {
      console.error('Add to cart error:', error);
      throw error;
    }
  }

  async function updateCartItem(itemId, quantity) {
    const data = await apiRequest(`/cart/${itemId}`, {
      method: 'PUT',
      body: JSON.stringify({ quantity }),
    });
    return data;
  }

  async function deleteCartItem(itemId) {
    const data = await apiRequest(`/cart/${itemId}`, { method: 'DELETE' });
    return data;
  }

  async function computeCartCount() {
    try {
      console.log('Computing cart count...');
      const cart = await getCart();
      console.log('Cart data:', cart);
      const count = cart.items.reduce((sum, item) => sum + (item.quantity || 0), 0);
      console.log('Computed count:', count);
      return count;
    } catch (error) {
      console.error('Error computing cart count:', error);
      return 0;
    }
  }

  async function refreshCartBadge() {
    const badge = document.querySelector('.cart-badge');
    if (!badge) {
      console.log('Cart badge not found');
      return;
    }
    try {
      console.log('Refreshing cart badge...');
      const count = await computeCartCount();
      console.log('Cart count:', count);
      badge.textContent = String(count);
    } catch (error) {
      console.error('Error refreshing cart badge:', error);
    }
  }

  global.PND_API = {
    fetchProducts,
    fetchProductBySlug,
    getCart,
    addToCart,
    updateCartItem,
    deleteCartItem,
    refreshCartBadge,
  };
  
  // Centralized, resilient add-to-cart button wiring
  function resolveProductIdFromContext(buttonElement) {
    // 1) Directly from the button
    const direct = buttonElement.getAttribute('data-product-id');
    if (direct) return Number(direct);

    // 2) From a parent container carrying the id
    const containerWithId = buttonElement.closest('[data-product-id]');
    if (containerWithId && containerWithId.getAttribute('data-product-id')) {
      return Number(containerWithId.getAttribute('data-product-id'));
    }

    // 3) From a product link that contains a slug parameter
    const productLink = buttonElement.closest('.product-card-need')?.querySelector('a[href*="product-details"]');
    if (productLink) {
      try {
        const url = new URL(productLink.getAttribute('href'), window.location.origin);
        const slugFromLink = url.searchParams.get('slug');
        if (slugFromLink) return { slug: slugFromLink };
      } catch (_) {}
    }

    // 4) From current page URL (product details page)
    try {
      const pageUrl = new URL(window.location.href);
      const slugFromPage = pageUrl.searchParams.get('slug');
      if (slugFromPage) return { slug: slugFromPage };
    } catch (_) {}

    return null;
  }

  async function resolveConcreteProductId(resolution) {
    if (resolution == null) return null;
    if (typeof resolution === 'number') return resolution;
    if (typeof resolution === 'object' && resolution.slug) {
      try {
        const product = await fetchProductBySlug(resolution.slug);
        return product && product.id ? Number(product.id) : null;
      } catch (_) {
        return null;
      }
    }
    return null;
  }

  function attachAddToCartHandlers({ redirectToBasket = false } = {}) {
    const clickableSelectors = '.add-btn, .btn-add-to-cart';
    document.querySelectorAll(clickableSelectors).forEach(btn => {
      if (btn.dataset.cartWired === '1') return;
      btn.dataset.cartWired = '1';
      btn.addEventListener('click', async (e) => {
        try {
          if (e) {
            e.preventDefault();
            e.stopPropagation();
          }
          const resolution = resolveProductIdFromContext(btn);
          const productId = await resolveConcreteProductId(resolution);
          if (!productId) {
            throw new Error('Product information not found');
          }
          await addToCart(productId, 1);
          await refreshCartBadge();

          // Try to show modal if available
          const modalEl = document.getElementById('cartModal');
          if (modalEl && global.bootstrap) {
            try {
              const modal = global.bootstrap.Modal.getOrCreateInstance(modalEl);
              modal.show();
            } catch (_) {}
          }

          if (redirectToBasket) {
            window.location.href = '/basket';
          }
        } catch (err) {
          console.error('Add to cart failed', err);
          alert(err.message || 'Failed to add to basket');
        }
      });
    });
  }

  // Auto-wire on DOM ready without interfering with page-specific scripts
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => attachAddToCartHandlers());
  } else {
    attachAddToCartHandlers();
  }

  // Expose the helper for pages that want to force re-wiring after dynamic inserts
  global.PND_API.attachAddToCartHandlers = attachAddToCartHandlers;
})(window);
