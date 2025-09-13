<?php include('src/php/db.php'); session_start(); ?>
<!doctype html><html><head><meta charset='utf-8'><title>My Orders</title>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'></head>
<body class='container py-4'>
<h2>My Orders</h2>
<div id='root'></div>
<script src='https://unpkg.com/react@18/umd/react.development.js'></script>
<script src='https://unpkg.com/react-dom@18/umd/react-dom.development.js'></script>
<script src='https://unpkg.com/babel-standalone@6/babel.min.js'></script>
<script type='text/babel'>
function Orders(){
  const [orders, setOrders] = React.useState([]);
  React.useEffect(()=>{
    fetch('src/php/orders_api.php').then(r=>r.json()).then(setOrders);
  },[]);
  if(orders.length===0) return <div className='alert alert-info'>No orders found.</div>;
  return (<div>{orders.map(o=>(<div className='card mb-3' key={o.id}><div className='card-body'><h5>Order #{o.id} - ₹{o.total_amount}</h5><p>Status: {o.status}</p><p>Items:</p><ul>{o.items.map(i=> <li key={i.name}>{i.name} x {i.quantity}</li>)}</ul></div></div>))}</div>);
}
ReactDOM.render(<Orders/>, document.getElementById('root'));
</script>
</body></html>