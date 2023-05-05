let featured = document.getElementById('featured');


// CHANGE WEEKLY SPECIALS HERE

let featuredItemsData = [
    {
    id:"Oreo Cookie Donut",
    desc:"Introducing our Weekly Featured Donut - the Oreo Cookie Donut! This decadent treat combines the classic flavors of our fluffy, freshly-made donut with a creamy Oreo cookie filling and a generous sprinkle of crushed Oreo cookie crumbs on top. It's the perfect indulgence for Oreo lovers and donut enthusiasts alike. But don't wait too long to try it - this limited edition donut is only available this week as our featured item!",
    price: "$4",
    img: "images/oreo2.jpg"
},
{
    id:"featured brewer",
    desc:"The Bean SLC, carefully selects and roasts their 100% Kona Peaberry beans to perfection, ensuring a rich and flavorful cup every time. Paired with any of our delicious donuts, our weekly featured brew is the perfect way to start your day. Come by and discover the best of what our community has to offer!",
    price:"12oz-$2.45 16oz-$2.65",
    img: "images/coffee.jpg"
},
]


let generateFeatured = () => {
    return(featured.innerHTML = featuredItemsData
        .map((x)=>{
            let {id, name, price, desc, img} = x;
            return`
    <div class="item col-lg-6 wow flipInX">
    <div class="d-flex align-items-center">
        <img style="width: 150px;" src="${img}" alt="" class="img-fluid flex-shrink-0 rounded">
        <div class="w-100 d-flex flex-column text-start ps-4">
            <h5 class="d-flex justify-content-between border-bottom pb-2">
                <span>${id}</span>
                <span class="text">${price}</span>
            </h5>
            <small class="fst-italic">${desc}</small>
        </div>
    </div>
</div> `
}).join(""));
};

generateFeatured();








