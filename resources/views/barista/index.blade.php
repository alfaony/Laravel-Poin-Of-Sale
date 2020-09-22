@extends('front.tamplate')
@section('header')		
	<style>
	.switch {
	position: relative;
	display: inline-block;
	width: 60px;
	height: 34px;
	}

	.switch input { 
	opacity: 0;
	width: 0;
	height: 0;
	}

	.slider {
	position: absolute;
	cursor: pointer;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background-color: #ccc;
	-webkit-transition: .4s;
	transition: .4s;
	}

	.slider:before {
	position: absolute;
	content: "";
	height: 26px;
	width: 26px;
	left: 4px;
	bottom: 4px;
	background-color: white;
	-webkit-transition: .4s;
	transition: .4s;
	}

	input:checked + .slider {
	background-color: #2196F3;
	}

	input:focus + .slider {
	box-shadow: 0 0 1px #2196F3;
	}

	input:checked + .slider:before {
	-webkit-transform: translateX(26px);
	-ms-transform: translateX(26px);
	transform: translateX(26px);
	}

	/* Rounded sliders */
	.slider.round {
	border-radius: 34px;
	}

	.slider.round:before {
	border-radius: 50%;
	}
	</style>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endsection
@section('content')
<div id="app">
<section class="header-main">
	<div class="container">
	<div class="row align-items-center">
	<div class="col-lg-3">
	<div class="brand-wrap">
		<h2 class="logo-text">BARISTA</h2>
	</div> <!-- brand-wrap.// -->
	</div>
	<div class="col-lg-3 col-sm-6">
		<div class="widgets-wrap d-flex justify-content-end">
			<div class="widget-header-left">
					<label class="switch">
						<input type="checkbox" v-model="checkbox">
						<span class="slider round"></span>
					</label>
				</div>
			<div class="widget-header">
				<a href="" class="icontext">
					<a href="{{ route('barista.layout') }}" class="btn btn-primary m-btn m-btn--icon m-btn--icon-only">
															<i class="fa fa-home"></i>
														</a>
					</a>
			</div> <!-- widget .// -->
			<div class="widget-header-right">
				<a href="" class="icontext">
					<a href="{{ route('barista.produk') }}" class="btn btn-primary m-btn m-btn--icon m-btn--icon-only">
															<i class="fa fa-plus"></i>
														</a>
					</a>
			</div> <!-- widget .// -->
		</div>	<!-- widgets-wrap.// -->	
	</div> <!-- col.// -->
</div> <!-- row.// -->
	</div> <!-- container.// -->
</section>

<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content padding-y-sm bg-default ">
<div class="container-fluid">
<div class="row" v-if="checkbox == true">
	<div class="col-md-7 card padding-y-sm card" id="cardTimeline">
		<span>
		<div class="timeline" v-for="(buy,index) in pembelian">
			<div class="container left" v-if="buy.antrian%2 == 1">
				<div class="content">
				<h4>@{{buy.user_id}} </h2>
				<table>
					<tr>
						<th scope="col">
							Name
						</th>
						<th scope="col">
							Jumlah
						</th>
					</tr>					
					<tr v-for="item in buy.to_order">
						<td class="col-sm-1"> 
							@{{item.produk_subcategori.produk.name}} @{{item.produk_subcategori.subcategori.name}}
						</td>
						<td class="col-md-1">
							@{{item.qty}}
						</td>
					</tr>
					<tr>
						<td>
							<button v-on:click="selesaiPembelian(buy.code)" class="btn btn-primary btn-block"prod ><i class="fa fa-cart-plus"></i> SELESAI </button>
						</td>
						<td>
							<button class="btn btn-danger btn-block"prod type="submit"><i class="fa fa-plus"></i> EDIT </span></button>
						</td>
					</tr>
				</table>

				</ul>
				</div>
			</div>
			<div class="container right" v-if="buy.antrian%2 == 0">
				<div class="content">
				<h4>@{{buy.user_id}} </h2>
				<table>
					<tr>
						<th scope="col">
							Name
						</th>
						<th scope="col">
							Jumlah
						</th>
					</tr>					
					<tr v-for="item in buy.to_order">
						<td class="col-sm-1"> 
							@{{item.produk_subcategori.produk.name}} @{{item.produk_subcategori.subcategori.name}}
						</td>
						<td class="col-md-1">
							@{{item.qty}}
						</td>
					</tr>
					<tr>
						<td>
							<button v-on:click="selesaiPembelian(buy.code)" class="btn btn-primary btn-block"prod ><i class="fa fa-cart-plus"></i> SELESAI </button>
						</td>
						<td>
							<button class="btn btn-danger btn-block"prod type="submit"><i class="fa fa-plus"></i> EDIT </span></button>
						</td>
					</tr>
				</table>

				</ul>
				</div>
			</div>
		</div>	
	</div>
	</span>

	<div class="col-md-5" >
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
				<tbody v-for="data in getBil.to_order">
					<td>
						@{{data.produk_subcategori.produk.name}}
					</td>
					<td>
						@{{data.produk_subcategori.subcategori.name}}
					</td>
					<td>
						@{{data.qty}}
					</td>
					<td>
						@{{data.harga}}
					</td>
					<td>
						DELETE
					</td>
				</tbody>
				</table>
				</span>
		</div> <!-- card.// -->
		<div class="box">
		<!-- ORDER -->
			<div> 
				<form action="#"  method="post">
				<dl class="dlist-align">
						<dt>Nama </dt>
					<dd class="text-right">
					<select v-model="bil"  name="user_id" id="customer">
						<option v-if="!pembeli.length" selected>Nama Kosong</option>
						<option v-for="data in pembeli" v-bind:value="data.code">@{{data.user_id}}</option>
					</select>
				</dl>
				<dl class="dlist-align">
					<dt>Antrian</dt>
					<dd class="text-right"><a href="#">@{{getBil.antrian}}</a>  <span v-if="!getBil.length">0</span> </dd>
				</dl>	
				<dl class="dlist-align">
					<dt>No Nota</dt>
					<dd class="text-right"><a href="#">@{{getBil.code}}</a> <span v-if="!getBil.length">0</span> </dd>
				</dl>
				<dl class="dlist-align">
				<dt>Total:</dt>
				<dd class="text-right" v-model="total">@{{getBil.total | currency}} <span v-if="!getBil.length">0</span> </dd>
				</dl>
				<dl class="dlist-align">
				<dt>Bayar:</dt>
				<dd class="text-right" v-model="bayar"> Rp<input type="number"></dd>
				</dl>
				<dl class="dlist-align">
				<dt>Kembalian: </dt>
				<dd class="text-right h4 b">@{{kembalian | currency}} <span v-if="!kembalian.length">0</span> </dd>
				</dl>
				</form>
			</div>
		<!-- REORDER -->
		</div> <!-- box.// -->
		</div>
	</div>
	</div><!-- container //  -->
	</div>
	</section>
</div>
	<!-- ========================= SECTION CONTENT END// ========================= -->
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script>
	$(document).ready(function() {
	    $('.js-example-basic-single').select2();
	});
	$(document).ready(function($){
		$("#phone").mask("9999-9999-9999");
	});
	// In your Javascript (external .js resource or <script> tag)
</script>
<script>
        $(function (){
            $("#customer").select2();
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
			pembeli:[],
			getBil:[],
			bil:"",	
			pembelian:[],
			checkbox:"",
			bayar:"",
			kerja:{
				tanggal:''
			}
		},
		mounted()
		{
			this.getTimeWork()
			setInterval(() => {
				axios.get("http://localhost:8000/api/pembelianToday").then(response =>{
							// console.log(response.data)
							this.pembeli = response.data
						});
				axios.get("http://localhost:8000/api/pembelian").then(response =>{
							// console.log(response)
							this.pembelian = response.data
							this.messages.unshift(this.pembelian)
							this.getPembelianToday()
						});
			},5000);

		},
		computed:{
			kembalian: function(){
				return this.getBil.total - this.bayar
			}
		},
		watch:{
			'checkbox' : function()
			{
				if(this.checkbox == true)
				{
					this.getKerja();
					// this.getPembelian();
					
				}else if(this.checkbox == false)
				{
					this.getKerja();
					this.kerja = [];
				}
			},
			'bil' : function()
			{
				this.gettingBil()
			}
		},
		methods:{
			getTimeWork()
			{
				axios.get("http://localhost:8000/api/getTimeWork").then(response=>{
					this.checkbox = response.data
				});
			},
			getPembelian()
			{
					axios.get("http://localhost:8000/api/pembelian").then(response =>{
							// console.log(response)
							this.pembelian = response.data
						});
			},
			getPembelianToday()
			{
					axios.get("http://localhost:8000/api/pembelianToday").then(response =>{
							// console.log(response)
							this.pembeli = response.data
						});
			},
			getKerja()
			{
				let kondisi="";
				switch(this.checkbox)
				{
					case true:
						kondisi = 'open';
					break;
					case false:
						kondisi = 'close';
					break;
				}

				axios.post("http://localhost:8000/api/kerja",{
					'kondisi': kondisi
				}).then(response =>{
					this.kerja.tanggal = response.data.tanggal
					});
			},
			selesaiPembelian(code)
			{
				axios.put("http://localhost:8000/api/updateBuy",
				{
					'code': code
				}).then(response =>{
						this.getPembelian();
					});
			},
			gettingBil()
			{
				
				axios.post("http://localhost:8000/api/getBil",{
					'code': this.bil
				}).then(response =>{

					this.getBil = response.data
					});
			}
		}
	})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
@endsection
