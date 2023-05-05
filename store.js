let shop = document.getElementById('shop');

let shopItemsData = [{
    id:"SpecialDonut",
    name:"Oreo Donut",
    price: 4,
    desc: "Weekly Special",
    img: "images/oreo2.jpg"
},
{
    id:"coffeeS",
    name:"Fresh Brew 12oz",
    price: 2.45,
    desc: "Weekly Special",
    img: "images/coffee-unsplash.jpg"
},
{
    id:"coffeeL",
    name:"Fresh Brew 16oz",
    price: 2.65,
    desc: "Weekly Special",
    img: "images/coffee-unsplash.jpg"

},
{
    id:"weeklyglaze",
    name:"Traditional Glazed",
    price: 2,
    desc: "Weekly Special",
    img: "images/glazed.jpg"
},
{
    id:"weeklychoco",
    name:"Oreo Donut",
    price: 5,
    desc: "Weekly Special",
    img: "images/oreo.jpg"
},
{
    id:"weeklystraw",
    name:"Oreo Donut",
    price: 5,
    desc: "Weekly Special",
    img: "images/oreo.jpg"
},
{
    id:"weeklyboston",
    name:"Oreo Donut",
    price: 5,
    desc: "Weekly Special",
    img: "images/oreo.jpg"
},
];

let basket = []

let generateShop =()=>{
    return (shop.innerHTML= shopItemsData
        .map((x)=>{
            let {id, name, price, desc, img} = x;
            return`
            <div id=product-id-${id} class="item">
            <img width="220" src="${img}" alt="">
            <div class="details">
              <h3>${name}</h3>
              <p>${desc}</p>
              <div class="price-quantity">
                <h2>$ ${price}</h2>
                <div class="buttons">
                  <i onclick="decrement(${id})" class="fa-solid fa-minus"></i>
                  <div id=${id} class="quantity">0</div>
                  <i onclick="increment(${id})" class="fa-solid fa-plus"></i>
                </div>
              </div>
            </div>
          </div>
            `
    }).join(""));
};

generateShop();

let increment = (id)=>{
    let selectItem = id;
    let search = basket.find((x)=> x.id === selectItem.id);

    if(search === undefined){
        basket.push({
            id: selectItem.id,
            item: 1,
        });
    }
    else{
        search.item += 1;
    }
console.log(basket);
};
let decrement = (id)=>{
    let selectItem = id;
    let search = basket.find((x)=> x.id === selectItem.id);

    if(search.item === 0) return;
    else{
        search.item -= 1;
    }
console.log(basket);
};
let update = ()=>{};