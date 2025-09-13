<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'><title>GrameenKart - Shop</title>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body class='container py-4'>
<header class='d-flex justify-content-between align-items-center mb-3'>
  <h2>GrameenKart</h2>
  <div>
    <select id='lang' class='form-select form-select-sm d-inline-block' style='width:120px; margin-right:8px'>
      <option value='en'>English</option><option value='hi'>हिन्दी</option><option value='mr'>मराठी</option>
    </select>
    <a href='cart.php' class='btn btn-outline-primary me-2' id='cartBtn'>Cart</a>
    <span id='authLinks'></span>
  </div>
</header>
<div id='root'></div>
<script src='https://unpkg.com/react@18/umd/react.development.js'></script>
<script src='https://unpkg.com/react-dom@18/umd/react-dom.development.js'></script>
<script src='https://unpkg.com/babel-standalone@6/babel.min.js'></script>
<script type='text/babel'>
const labels = {
  en: { add:'Add to Cart', price:'Price', cart:'Cart', login:'Login', register:'Register', orders:'My Orders' },
  hi: { add:'कार्ट में जोड़ें', price:'कीमत', cart:'कार्ट', login:'लॉगिन', register:'रजिस्टर', orders:'मेरे ऑर्डर' },
  mr: { add:'कार्टमध्ये जोडा', price:'किंमत', cart:'कार्ट', login:'लॉगिन', register:'नोंदणी', orders:'माझी ऑर्डर्स' }
};
function App(){
  const [products, setProducts] = React.useState([]);
  const [lang, setLang] = React.useState('en');
  const [userHtml, setUserHtml] = React.useState('');

  React.useEffect(()=>{
    fetch('src/php/product_api.php').then(r=>r.json()).then(setProducts);
    updateAuthLinks();
    document.getElementById('lang').addEventListener('change', e=> setLang(e.target.value));
  },[]);

  function updateAuthLinks(){
    fetch('src/php/check_session.php').then(r=>r.json()).then(data=>{
      if(data.logged){
        setUserHtml(`<span class='me-2'>${data.name}</span> <a href='orders.php' class='btn btn-sm btn-outline-secondary me-2'>${labels[lang].orders}</a> <a href='logout.php' class='btn btn-sm btn-outline-danger'>Logout</a>`);
      } else {
        setUserHtml(`<a href='login.php' class='btn btn-sm btn-outline-primary me-2'>${labels[lang].login}</a><a href='register.php' class='btn btn-sm btn-outline-success'>${labels[lang].register}</a>`);
      }
      document.getElementById('authLinks').innerHTML = userHtml;
    });
  }

  return (<div className='row'>
    {products.map(p => (
      <div className='col-sm-6 col-md-4 col-lg-3 mb-4' key={p.id}>
        <div className='card h-100'>
          <img src={'public/images/'+p.image} className='card-img-top' style={{height:160,objectFit:'cover'}} onError={(e)=>e.target.src='public/images/placeholder.png'} />
          <div className='card-body d-flex flex-column'>
            <h5 className='card-title'>{p.name}</h5>
            <p className='card-text'>{p.description}</p>
            <div className='mt-auto'>
              <p className='h6'>₹{p.price}</p>
              <a href={`cart.php?add=${p.id}`} className='btn btn-primary w-100'>{labels[lang].add}</a>
            </div>
          </div>
        </div>
      </div>
    ))}
  </div>);
}

ReactDOM.render(<App/>, document.getElementById('root'));

</script>
</body>
</html>