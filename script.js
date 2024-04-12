// Sample product data
const products = [
    { id: 1, name: 'Product A', price: 10.99 },
    { id: 2, name: 'Product B', price: 20.99 },
    { id: 3, name: 'Product C', price: 30.99 }
  ];
  
  // Function to display products on the page
  function displayProducts() {
    const productList = document.getElementById('product-list');
    productList.innerHTML = '';
  
    products.forEach(product => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${product.id}</td>
        <td>${product.name}</td>
        <td>${product.price}</td>
        <td><button onclick="addToCart(${product.id})">Add to Cart</button></td>
      `;
      productList.appendChild(row);
    });
  }
  
  // Function to add product to cart (example function)
  function addToCart(productId) {
    alert(`Product with ID ${productId} added to cart!`);
  }
  
  // Display products when the page loads
  displayProducts();
  