@extends('front.tamplate')
@section('content')
<div id="app">
	<section class="header-main">
		<div class="container">
	<div class="row align-items-center">
		<div class="col-lg-3">
		<div class="brand-wrap">
			<h2 class="logo-text">Ibaraki Order</h2>
		</div> <!-- brand-wrap.// -->
		</div>
		<div class="col-lg-3 col-sm-6">
			<div class="widgets-wrap d-flex justify-content-end">
				<div class="widget-header">
						<a href="#" class="btn btn-primary m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-home"></i></a>
				</div> <!-- widget .// -->
				<div class="widget-header dropdown">
					<a href="#" class="ml-3 icontext" data-toggle="dropdown" data-offset="20,10">
						<img src="assets/images/avatars/bshbsh.png" class="avatar" alt="">
					</a>
				</div> <!-- widget  dropdown.// -->
			</div>	<!-- widgets-wrap.// -->	
		</div> <!-- col.// -->
	</div> <!-- row.// -->
		</div> <!-- container.// -->
	</section>
	<!-- ========================= SECTION CONTENT ========================= -->
	<section class="section-content padding-y-sm bg-default ">
	<div class="container-fluid">
	<div class="row">
		<div class="col-md-7 card padding-y-sm card">
            <table>
			<tr>
				<td colspan ="2">
							<div v-if="success" class="alert alert-success">
                                Masuk ke kranjang :)
                            </div>
				</td>
			</tr>
                <tr>
                    <td>	
                            <div class="form-group">
								<select v-model='kategori' class="custom-select mr-sm-2" id="exampleFormControlSelect1" 	>
                                    <option value="null" selected>All</option>
									@foreach($categori as $a)
										<option value="{{$a->id}}">{{$a->name}}</option>
									@endforeach
                                </select>
                        </div>
                    </td>
                    <td>
                    <div class="form-group">
                        <input type="search" v-model="search" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Search....">
					</div>
                    </td>
                </tr>
            </table>
			<!-- <button v-on:click="toOrder('257','295',10000,4150)" >Kirim</button> -->
	<span>
	<div class="row" v-for="chunk in produkChunk">
		<div class="col-md-4" v-for="produk in chunk">
			<figure class="card card-product">
				<!-- <div class="img-wrap">  -->
					<center><img src="{{ asset('transaksi/images/items/ibaraki.png')}}" width="100px" height="100px"></center>
				<!-- </div> -->
				<figcaption class="info-wrap">	
					<!-- <a href="#" class="title">@{{produk.name}}</a> -->
					<center><span>@{{produk.name}}</span></center>
					<div class="action-wrap">
						<div class="form-group">
							<!-- FORM PROBLEM -->
							<form action="/" @submit.prevent="addToCart" method="post" >
								<select v-model="produk_subcategori.produk_subcategori_id" class="form-control">
									<option value="">Pilih Kategori</option>
									<option v-for="subcategori in produk.subcategori" v-bind:value="subcategori.id" >@{{subcategori.subcategori.name}}</option>
								</select>
								<button class="btn btn-primary btn-block"prod type="submit"><i class="fa fa-cart-plus"></i> Add <span class="btn btn-primary"></span></button>
							</form>
							
						</div>
						<!-- <a href="#" class="btn btn-primary btn-sm float-right">  </a> -->
						<div class="price-wrap h5">
						</div> <!-- price-wrap.// -->
					</div> <!-- action-wrap -->
				</figcaption>
			</figure> <!-- card // -->
		</div> <!-- col // -->
	</div> <!-- row.// -->
	</span>
</div>
<div class="col-md-5">
	<div class="card">
		<span id="cart">
	<table class="table table-hover shopping-cart-wrap">
	<thead class="text-muted">
	<tr>
	<th scope="col">Item</th>
	<th scope="col">Kategori</th>
	<th scope="col" > <center>Qty </center></th>
	<th scope="col" >Price</th>
	<th scope="col" >Delete</th>
	</tr>
	</thead>
	<tbody>
		<tr v-for="cart in shoppingCart">
					<!-- <div v-if="success" class="alert alert-success">
                                Masuk ke kranjang :)
                    </div> -->
				<td v-if="null">
					Data Pembelian Kosong
				</td>
			<td>
				@{{cart.produk}}
			</td>
			<td>
				@{{cart.subcategori}}
			</td>
			<td class="text-center"> 
				<div class="m-btn-group m-btn-group--pill btn-group mr-2" role="group" aria-label="...">
																		<button type="button" v-on:click="minusCart(cart.id)" class="m-btn btn btn-default"><i class="fa fa-minus"></i></button>
																		<button type="button" class="m-btn btn btn-default">@{{cart.qty}}</button>
																		<button type="button" v-on:click="plusCart(cart.id)"  class="m-btn btn btn-default"><i class="fa fa-plus"></i></button>
				</div>
			</td>
			<td> 
				<div class="price-wrap"> 
					<var class="price"> @{{cart.harga * cart.qty | currency}} </var> 
				</div> <!-- price-wrap .// -->
			</td>
			<td> 
				<a href="#" class="del-goods" v-on:click="removeCart(cart.id)"><i class="fa fa-trash"></i></a>
			</td>
		</tr>
		<tr v-if="submitCart">
                <td colspan="5" class="text-center">
					<div v-if="submitCart" class="alert alert-danger">
						Belum ada pembelian jon
					</div>
				</td>
        </tr>
	</tbody>
	</table>
	</span>
	</div> <!-- card.// -->
	<div class="box">
	<dl class="dlist-align">
		<dt>Status</dt>
		<dd class="text-right">
		<select v-model="order">
			<option v-bind:value="2" selected>Pesan Ulang</option>
			<option v-bind:value="1" >Pesan</option>
		</select>
	</dl>
	<!-- ORDER -->
	<div v-if="order =='1'"> 
	<form action="#" @submit.prevent="checkout" method="post">
	<dl class="dlist-align">
		<dt>Nama </dt>
		<dd class="text-right">
		<input type="text" v-model="identitas.user_id" id="phone"  placeholder="NAMA PEMESAN.." require>
	</dl>
	<dl class="dlist-align">
		<dt>Pelanggan: </dt>
		<dd class="text-right">
		<select v-model="subtotal.tax">
			<option v-bind:value='0'>DINE-IN</option><option v-bind:value='30'>GO/GRAP</option>
		</select></dd>
	</dl>
	<dl class="dlist-align">
		<dt>Antrian</dt>
		<dd class="text-right"><a href="#">@{{identitas.antrian}}</a> <span v-if="submitCart"> </dd>
	</dl>	
	<dl class="dlist-align">
		<dt>No Nota</dt>
		<dd class="text-right"><a href="#">@{{identitas.code}}</a> <span v-if="submitCart"></span> </dd>
	</dl>
	<dl class="dlist-align">
		<dt>tax:</dt>
		<dd class="text-right"><a href="#">@{{subtotal.tax}}%</a></dd>
	</dl>
	<dl class="dlist-align">
	<dt>Sub Total:</dt>
	<dd class="text-right">@{{totalPrice | currency}}</dd>
	</dl>
	<dl class="dlist-align">
	<dt>Total: </dt>
	<dd class="text-right h4 b"> @{{alltotal | currency}} </dd>
	</dl>
	<div class="row">
		<div class="col-md-6">
			<a href="#" class="btn  btn-default btn-error btn-lg btn-block"><i class="fa fa-times-circle "></i> Cancel </a>
		</div>
		<div class="col-md-6">
			<!-- <a href="#" v-on:click="checkout()" class="btn  btn-primary btn-lg btn-block"><i class="fa fa-shopping-bag"></i> Beli </a> -->
			<button class="btn  btn-primary btn-lg btn-block"><i class="fa fa-shopping-bag"></i> Beli </button>
		</div>
	</div>
	</form>
	</div>
	<!-- REORDER -->
	<div v-if="order =='2'"> 
	<!-- @{{identitas}} -->
	<form action="#" @submit.prevent="checkout" method="post">
	<dl class="dlist-align">
		<dt>Antrian</dt>
		<dd class="text-right"><input type="number" v-model="antrian" placeholder="0"></dd>
	</dl>
	<dl class="dlist-align">
		<dt>Nama</dt>
		<dd class="text-right">@{{identitas.user_id}} <span v-if="identitas.user_id == ''">.......</span></dd>
	</dl>		
	<dl class="dlist-align">
	<dt>Sub Total:</dt>
	<dd class="text-right">@{{totalPrice | currency}}</dd>
	</dl>
	<dl class="dlist-align">
	<dt>Total: </dt>
	<dd class="text-right h4 b"> @{{alltotal | currency}} </dd>
	</dl>
	<div class="row">
		<div class="col-md-6">
			<a href="#" class="btn  btn-default btn-error btn-lg btn-block"><i class="fa fa-times-circle "></i> Cancel </a>
		</div>
		<div class="col-md-6">
			<!-- <a href="#" v-on:click="checkout()" class="btn  btn-primary btn-lg btn-block"><i class="fa fa-shopping-bag"></i> Beli </a> -->
			<button class="btn  btn-primary btn-lg btn-block"><i class="fa fa-shopping-bag"></i> Beli </button>
		</div>
	</div>
	</form>
	</div>
	</div> <!-- box.// -->
		</div>
	</div>
	</div><!-- container //  -->
	</section>
</div>
@endsection
@section('footer')

<!-- ========================= SECTION CONTENT END// ========================= -->
<script src="{{asset('transaksi/js/OverlayScrollbars.js ')}}" type="text/javascript"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/accounting.js/0.4.1/accounting.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
	$(document).ready(function($){
		$("#phone").mask("9999-9999-9999");
	});
</script>
<script>
	//The passed argument has to be at least a empty object or a object with your desired options
	//$("body").overlayScrollbars({ });
	$(function(){
		$("#items").height(552);
		$("#items").overlayScrollbars({overflowBehavior : {
			x : "hidden",
			y : "scroll"
		} });
		$("#cart").height(445);
		$("#cart").overlayScrollbars({ });
	});
</script>
<script>
	Vue.filter('currency', function (money) {
            return accounting.formatMoney(money, "Rp ", 2, ".", ",")
        })

	new Vue({
		el: "#app",
		data: {
			// Kategori
			success: false,
			produk: [],
			antrian:'',
			kategori: 'null',
			search: '',
			produk_subcategori:{
				produk_subcategori_id:'',
				qty:1
			},
			subtotal:{
				tax:0
			},	
			//menampung identitas
			identitas: {
				user_id:'',
				status:'',
				code:'',
				antrian:'',
				tanggal:''
			},
			//untuk menampung list cart
			errorShopping:'',
			shoppingCart: [],
			submitCart: true,
			order:'2'
		},
		mounted()
		{
			// fetch data dari api menggunakan axios
			axios.get("http://localhost:8000/api/subcategori").then(response =>{
                this.produk = response.data
			});
			this.getCart()
		},
		computed: {
			totalPrice: function () 
			{
				let total = [];
				Object.entries(this.shoppingCart).forEach(([key, val]) => {
					if(val.qty == 0)
					{
						this.removeCart(val.id)
					}
					total.push(val.harga * val.qty) // the value of the current key.
				});
				result = total.reduce(function(total, num){ return total + num }, 0);
				// this.identitas.total = result
				return result
			},
			alltotal(){
				penjumlah = (this.totalPrice * this.subtotal.tax)/100
				result = this.totalPrice + penjumlah
				this.identitas.total = result
				return result
			},
			produkChunk(){
				if(this.kategori === "null"){
					if(this.search)
					{
						searchs = this.produk.filter(produk => {
							return produk.name.toLowerCase().includes(this.search.toLowerCase())
						});
						return _.chunk(Object.values(searchs), 3);
					}else
					{
						return _.chunk(Object.values(this.produk), 3);
					}
				}else{
					return _.chunk(Object.values(this.produk.filter(produk => produk.categori_id == this.kategori)), 3);
				}
			}
		},
		watch: {
			'order' : function()
			{
				if(this.order == 1)
				{
					this.getTotal();
				}
			},
			'antrian':function()
			{
				if(this.antrian)
				{
					this.findAntrian();
				}
			}
		},
		methods:{
			addToCart()
			{
				this.submitCart = true;
				//send data ke server
				axios.post('http://localhost:8000/api/cart', this.produk_subcategori)
				.then((response) => {
					//apabila berhasil, data disimpan ke dalam var shoppingCart
						
						if(response.data.status === 'tutup'){
							this.notiferror(response.data.pesan)
						}else
						{
						this.getCart()

							//mengosongkan var
						this.produk_subcategori.produk_subcategori_id = ''
						this.kategori='null'
						this.produk_subcategori.qty = 1
						this.submitCart = false
						}
				});
			},
			//mengambil list cart yang telah disimpan
			getCart(){
				// fetch data dari api menggunakan axios
				axios.get("http://localhost:8000/api/cart").then(response =>{
						this.shoppingCart = response.data
					});
        	},
			//menghapus cart
			// CART
			plusCart(id){
				axios.put(`http://localhost:8000/api/pluscart/${id}`)
						.then ((response) => {
							//load cart yang baru
							this.getCart();
							console.log(response);
						})
						.catch ((error) => {
							console.log(error);
						})
			},
			minusCart(id)
			{
				
				axios.put(`http://localhost:8000/api/minuscart/${id}`)
						.then ((response) => {
							//load cart yang baru
							this.getCart();
							console.log(response);
						})
						.catch ((error) => {
							console.log(error);
						})
			},
			removeCart(id)
			{
				//menampilkan konfirmasi dengan sweetalert
				axios.delete(`http://localhost:8000/api/cart/${id}`)
						.then ((response) => {
							//load cart yang baru
							this.getCart();
						})
						.catch ((error) => {
							console.log(error);
						})
			},
			checkout()
			{
				if(!this.identitas.user_id)
				{
					this.notiferror("Nama Belum diisi")
				}else if(this.submitCart == true)
				{	
					this.notiferror("Tidak ada pembelian")
				}else
				{
					this.createCheckout(this.identitas.user_id,this.subtotal.tax)
				}
			},
			getTotal()
			{
				axios.get("http://localhost:8000/api/total").then(response =>{
						if(response.data.kondisi == 'TUTUP')
						{
							this.order = "2"
							this.notiferror("Maaf Kami Sedang Tutup")
							this.getCart()
						}else
						{

							this.identitas.user_id = response.data.user_id
							this.identitas.antrian = response.data.antrian
							this.identitas.status = response.data.status
							this.identitas.code = response.data.code
							this.identitas.tanggal = response.data.tanggal
						}
						
					});
			},
			toOrder(produk_subcategori_id,qty,harga,laba)
			{
				axios.post("http://localhost:8000/api/toOrder",{
					'id_to': this.identitas.id_to,
					'produk_subcategori_id' : produk_subcategori_id,
					'qty' : qty,
					'status':'waiting',
					'harga': harga,
					'laba': laba,
					'total_order_code': this.identitas.code,
					'antrian': this.identitas.antrian,
					'tanggal': this.identitas.tanggal
					})
					.then(response => {
					// push router ke read data
						this.identitas.id_to = this.identitas.id_to + 1
					});
			},
			findAntrian()
			{
				axios.post('http://localhost:8000/api/antrian',
				{
					'antrian':this.antrian
				})
				.then((response) => 
				{
						this.identitas.id_to = response.data.id_to
						this.identitas.user_id = response.data.user_id
						this.identitas.code = response.data.code
						this.identitas.tanggal = response.data.tanggal
				});
			},
			createCheckout(user_id,tax)
			{
				axios.post("http://localhost:8000/api/checkout",{
					'user_id':user_id,
					'tax':tax,
					})
					.then(response => {
					// push router ke read data
						this.swal()
						this.order = 2
						this.identitas = []
						this.shoppingCart = []
						this.submitCart = true
						this.success = false
						this.antrian = ''
						this.subtotal.tax = 0
					});
			},
			swal()
			{
				swal({
					title: 'Terimakasih....!',
					text: 'Kami akan panggil nama untuk mengambil orderan',
					timer: 4500,
					icon:'success',
					buttons: false
					}).then(
					function () {},
					// handling the promise rejection
					function (dismiss) {
						if (dismiss === 'timer') {
						//console.log('I was closed by the timer')
						}
					}
				)
			},
			notiferror(pesan)
			{
				swal({
					title: pesan,
					timer: 2500,
					icon:'error',
					buttons: false
					}).then(
					function () {},
					// handling the promise rejection
					function (dismiss) {
						if (dismiss === 'timer') {
						//console.log('I was closed by the timer')
						}
					}
				)
			}
		}
	})
</script>
@endsection