// Simple data extracted from the TS project (adapted)
const dishes = [
  {
    id: 1,
    name: "Gourmet Burger Deluxe",
    description: "Premium beef patty with fresh vegetables, crispy bacon, and our signature sauce",
    price: 24.99,
    originalPrice: 29.99,
    rating: 4.8,
    reviews: 245,
    image: "assets/dish-1.jpg",
    badge: "Popular"
  },
  {
    id: 2,
    name: "Italian Pasta Primavera",
    description: "Fresh pasta with seasonal vegetables, herbs, and parmesan cheese in garlic olive oil",
    price: 19.49,
    originalPrice: 23.49,
    rating: 4.6,
    reviews: 198,
    image: "assets/dish-2.jpg",
    badge: "Chef's Choice"
  },
  {
    id: 3,
    name: "Asian Fusion Bowl",
    description: "Colorful stir-fried vegetables with choice of protein served over jasmine rice",
    price: 21.99,
    originalPrice: 25.99,
    rating: 4.7,
    reviews: 312,
    image: "assets/dish-3.jpg",
    badge: "Healthy"
  }
];

const restaurants = [
  {
    id: 1,
    name: "Bella Italia",
    cuisine: "Italian",
    rating: 4.8,
    reviews: 542,
    deliveryTime: "25-35 min",
    distance: "1.2 km",
    image: "https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=800&h=400&fit=crop",
    badges: ["Popular", "Fast Delivery"],
    priceRange: "$$"
  },
  {
    id: 2,
    name: "Dragon Palace",
    cuisine: "Chinese",
    rating: 4.7,
    reviews: 421,
    deliveryTime: "20-30 min",
    distance: "0.9 km",
    image: "https://images.unsplash.com/photo-1544025162-d76694265947?w=800&h=400&fit=crop",
    badges: ["Hot", "New"],
    priceRange: "$$"
  },
  {
    id: 3,
    name: "Green Leaf",
    cuisine: "Vegetarian",
    rating: 4.6,
    reviews: 189,
    deliveryTime: "30-40 min",
    distance: "2.1 km",
    image: "https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=800&h=400&fit=crop",
    badges: ["Healthy"],
    priceRange: "$$"
  },
  {
    id: 4,
    name: "Tokyo Sushi",
    cuisine: "Japanese",
    rating: 4.9,
    reviews: 267,
    deliveryTime: "35-45 min",
    distance: "1.8 km",
    image: "https://images.unsplash.com/photo-1579584425555-c3ce17fd4351?w=800&h=400&fit=crop",
    badges: ["Premium", "Fresh"],
    priceRange: "$$$"
  }
];

function money(n){ return new Intl.NumberFormat(undefined,{style:'currency', currency:'USD'}).format(n); }

function renderDishes(){
  const grid = document.getElementById('dishesGrid');
  grid.innerHTML = dishes.map(d => `
    <article class="group rounded-xl overflow-hidden bg-card border border-border hover:border-food-warm/50 transition-colors shadow-elegant">
      <div class="relative">
        <img src="${d.image}" alt="${d.name}" class="w-full h-48 object-cover">
        <span class="absolute top-3 left-3 px-3 py-1 rounded-full text-xs font-semibold bg-black/60 text-foreground border border-border">${d.badge}</span>
      </div>
      <div class="p-6">
        <div class="flex items-center gap-2 mb-2 text-sm text-muted">
          <span>★ ${d.rating}</span>
          <span>•</span>
          <span>(${d.reviews} reviews)</span>
        </div>
        <h3 class="text-lg font-semibold mb-2">${d.name}</h3>
        <p class="text-muted mb-4">${d.description}</p>
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-2">
            <span class="text-2xl font-bold text-food-warm">${money(d.price)}</span>
            ${d.originalPrice ? `<span class="text-sm text-muted line-through">${money(d.originalPrice)}</span>` : ``}
          </div>
          <button class="px-3 py-2 rounded-lg bg-secondary border border-border hover:bg-secondary/80">Add</button>
        </div>
      </div>
    </article>
  `).join('');
}

function renderRestaurants(){
  const grid = document.getElementById('restaurantsGrid');
  grid.innerHTML = restaurants.map(r => `
    <article class="rounded-xl overflow-hidden bg-card border border-border shadow-elegant">
      <div class="relative">
        <img src="${r.image}" alt="${r.name}" class="w-full h-40 object-cover">
        <div class="absolute top-3 right-3 flex gap-2">
          ${r.badges.map(b => `<span class="px-2 py-1 rounded-full text-xs bg-black/60 border border-border">${b}</span>`).join('')}
        </div>
      </div>
      <div class="p-6">
        <div class="flex items-start justify-between mb-2">
          <div>
            <h3 class="text-lg font-semibold">${r.name}</h3>
            <p class="text-muted">${r.cuisine} Cuisine</p>
          </div>
          <div class="text-sm text-muted">★ ${r.rating} <span class="opacity-70">(${r.reviews})</span></div>
        </div>
        <div class="flex items-center justify-between text-sm text-muted">
          <div class="flex items-center gap-2">
            <span>⏱ ${r.deliveryTime}</span>
            <span>•</span>
            <span>📍 ${r.distance}</span>
          </div>
          <div>${r.priceRange}</div>
        </div>
      </div>
    </article>
  `).join('');
}

document.getElementById('year').textContent = new Date().getFullYear();
renderDishes();
renderRestaurants();