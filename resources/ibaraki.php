<?php
				class pesan extends Line_Apps{
							
					function on_follow()
					{
						
						$this->session->set('menu',null);
						//order
						$this->session->set('pilih','pesan');
						$this->session->set('code',null);
						$this->session->set('member',null);
						$this->session->set('item',null);
						$this->session->set('keadaan',null);
						$this->session->set('antrian','1');
						$this->session->set('laba',null);
						$this->session->set('delete',null);

						
						//barista
						$this->session->set('barsita',null);
						$this->session->set('password',null);
						$this->session->set('waktu',null);
						$this->session->set('update',null);
						$this->session->set('nonota',null);
						$this->session->set('bar',null);
						
					
						//array
						//antrian
						$msg[] = "Welcome To ibraki koffie ".$this->profile->display_name;
						$msg[] = "Semoga Sukses selalu";
						
						return $msg;
					}
					
					function on_message($message)
					{
						date_default_timezone_set("Asia/Bangkok");
						
						$text = $message['text'];
						$text= trim(strtolower($text));
						//settingCode
					
						
						//tanggal
						
						if($this->session->get('waktu') == null)
						{
							//$date = '0000-00-00';
							//$date = '2019-11-01';
							$date = date('Y-m-d');
							$this->session->set('waktu',$date);	
						}
						if($this->session->get('menu')!= null)
						{
							if($this->session->get('menu') == 'barista')
							{
								switch($this->session->get('barista'))
								{
									case 'greating':
										$input = $text;
										$input = explode("@",$text);
										
										$db = new Database();
										$barista = $db->query("SELECT * FROM barista where user_id = '{$this->profile->user_id}' and username ='{$input[0]}' and password = '{$input[1]}'");
										$data = $barista->fetch_object();
										
										$time_now = date('h:i:s');
						
										if($data)
										{
											
											$time_now = date('h:i:s');
											
											$db = new Database();
											$insert = $db->query("INSERT INTO `kerja`(tanggal,userid,jam_buka) VALUES('{$this->session->get('waktu')}','{$this->profile->user_id}','{$time_now}') ON DUPLICATE KEY UPDATE status='ready',userid='{$this->profile->user_id}',jam_tutup='null',total='null',sales='null',profit='null'");
													
											$this->session->set('barista','kerja');
											
											$messages[] = array('type' => 'text', 'text' => "Halo Ibaraki sudah buka..Silahkan untuk Order");
											//$this->bot->pushMessage('U1ce722b8407b007ef1cf356b3b9196ce',$messages);
											
											$msg[] = "Halo ".$this->profile->display_name;
											$msg[] ="Hari ini tanggal ".$this->session->get('waktu')."Waktu Buka ".$time_now;
											$msg[] = "Semangat bekerja dan semoga berkah mas.Jangan lupa sholat";
											$msg[] = " FITUR-FITUR IBARAKI
												1. Nota
												2. Update Produk -tersedia- dan -tidak-
												3. Delete Nota dan atau pesanan	
											";

											$msg[] = array('type' => 'template',
																'altText' => 'Jika Pesanan sudah,silahkan pilih selesai',
																'template'=> array(
																	'type'=> 'confirm',
																	'text'=> 'SEMNGAT !!!!',
																	'actions'=> array(
																		array('type'=> 'message','label'=> 'kerja','text'=> 'kerja'),
																		array('type'=> 'message','label'=> '.','text'=> 'kerja')
																)
														));
											
										}else{
											$msg[] = "Login gagal";
										}
										
										return $msg;
										break;
									case "kerja":
										if($text  == 'tutup')
										{
											
											$this->session->set('menu',null);
											$this->session->set('barsita',null);
											$this->session->set('password',null);
											
											
											$db = new Database();
											
											$time_now = date('h:i:s');
											
											
											//$komunikasi = $db->query("DELETE FROM to_order WHERE code not in (SELECT code FROM total_order)");
											$tutup  = $db->query("UPDATE profiles SET session_data = 'null' WHERE user_id ='{$this->profile->user_id}'");
											$tutup1  = $db->query("UPDATE profiles SET session_data = 'null' WHERE status ='service'");
											
											$laporan = $db->query("SELECT sum(total) as total,sum(laba) as profit FROM total_order WHERE tanggal = '{$this->session->get('waktu')}'");
											$laporan_fetch = $laporan->fetch_array();
											

											$total = $laporan_fetch['total'];
											$profit = $laporan_fetch['profit'];
											$sales = $total-$profit;
											
											$update = $db->query("UPDATE kerja SET jam_tutup='{$time_now}',status='tutup',total='{$total}',sales='{$sales}',profit='{$profit}' WHERE tanggal = '{$this->session->get('waktu')}'");
											
											$msg[] = "Terimaksih mas ".$this->profile->display_name."Waktu ".$time_now;
											$msg[] = $this->session->get('waktu');
											$msg[] = "Semoga ilmunya bermanfaat";

											return $msg;
											
											//waktu
											$this->session->set('waktu',null);
										
											
										}elseif($text == 'masalah')
										{
											$this->session->set('barista','ngebar');
											$msg[] = "Barikan kami masukan dan masalah yang membuat kamu";
											
											return $msg;
										}elseif($text == '1')
										{
											$this->session->set('barista','nota');
											$msg[] = "Silahkan masukan no antrian";
											
											return $msg;
										}elseif($text == '2')
										{
											$this->session->set('barista','update');
											$msg[] = "Masukan ID produk";
											
											return $msg;
										}elseif($text == '3')
										{
											$this->session->set('barista','destroy');
											$msg[] = "Masukan no dan atru id_produk produk";
											$msg[] = "Misal --1-- atau 1@5";
											return $msg;
											
										}else
										{
											$db = new Database();
											$total_transaksi = $db->query("SELECT * FROM total_order WHERE tanggal = '{$this->session->get('waktu')}' and status ='waiting' limit 2");
						
											if(isset($total_transaksi))
											{
												$data = array();
												foreach($total_transaksi as $a)
												{
																		// REPAIR
																		$select = $db->query("SELECT 
																		id_to,produk.name as name_produk,subcategori.name AS name_subcategori
																		FROM `to_order`,`produk`,`subcategori` WHERE 
																		id_produk = produk.id AND
																		idproduk = subcategori.id AND
																		code ='{$a['code']}' ORDER BY id_to");

																		$sum = $db->query("SELECT sum(harga) as harga from to_order where code ='{$a['code']}'");
																		$result_sum = $sum->fetch_array();

																		$update = $db->query("update total_order set status='done' where code ='{$a['code']}'");
																		$antrian = $a['antrian'];

																		$data = array();
																		$no = 1;
																		foreach($select as $a)
																		{
																			$prod = strtoupper($a['name_produk']." ".$a['name_subcategori']);
																			array_push($data,$no." .".$prod);
																			$no ++;
																		}
																		$dataImplode = implode("\n",$data);
																		$tagihan = "No Nota :".$antrian."\n"."Total :".$result_sum['harga'];
																		$msg[] = array('type' => 'text',
																						'text' => $dataImplode."\n \n"."Tagihan :Rp".$tagihan);
																		$msg[] = array('type' => 'text',
																						'text' =>"=>=>SELANJUTNYA<=<=");
																		}
																				// $this->bot->pushMessage("Ua11d322b8357d47b762b653331a224c0",$msg);
																				$msg[] = array('type' => 'template',
																										'altText' => 'confirm play again',
																										'template'=> array(
																											'type'=> 'confirm',
																											'text'=> 'Selesaikan Pesanan',
																											'actions'=> array(
																												array('type'=> 'message','label'=> 'selesai','text'=> 'SELESAI'),
																												array('type'=> 'message','label'=> 'tutup','text'=> 'TUTUP')
																												)
																										)
																								);
													
																	}else
																		{

																	$msg[] = array('type' => 'template',
																										'altText' => 'confirm play again',
																										'template'=> array(
																											'type'=> 'confirm',
																											'text'=> 'Tidak ada pelanggan',
																											'actions'=> array(
																												array('type'=> 'message','label'=> 'selesai','text'=> 'SELESAI'),
																												array('type'=> 'message','label'=> 'tutup','text'=> 'TUTUP')
																												)
																										)
																								);
																	return $msg;
																	}	
																	return $msg;
										}
										break;
									case 'update':
										if($text == 'selesai')
										{
												return $this->kerja();
										}
										elseif(($text =='kosong')or($text == 'ready'))
										{
											$db = new Database();
											$update = $db->query("update produks set ketersediaan ='{$text}' where id = '{$this->session->get('update')}'");
											switch ($text) {
												case 'kosong':
													
													$db = new Database();
													
													//show barista
													$selects = $db->query("SELECT produks.nama,total_order.antrian,COUNT(to_order.id_produk) as jumlah FROM to_order,total_order,produks 
													WHERE to_order.code = total_order.code 
													AND total_order.status = 'waiting' 
													AND to_order.id_produk = produks.id
													AND to_order.id_produk = '{$this->session->get('update')}' 
													AND to_order.tanggal = '{$this->session->get('waktu')}' GROUP BY total_order.code");

													$select = $db->query("SELECT id_produk,to_order.code FROM to_order,total_order 
													WHERE to_order.code = total_order.code 
													AND total_order.status = 'waiting' 
													AND to_order.id_produk = '{$this->session->get('update')}'
													AND to_order.tanggal = '{$this->session->get('waktu')}'
													");
													
					
													foreach ($select as $key)
													{
														$this->deleteProd($key['id_produk'],$key['code']);
													}												

													$array = array();
													$no = 1;
													foreach ($selects as $a)
													{
														array_push($array,$no." (".$a['antrian'].") ".$a['nama']." >".$a['jumlah']."<");
														$no++;
													}
													$implode = implode("\n",$array);
													$msg[] = array(
														"type"=> "flex",
														"altText"=> "Flex Message",
														"contents" => array("type"=>"bubble","body"=>array("type"=> "box","layout"=> "vertical","spacing"=> "sm","contents"=> array(
																array("type"=> "text","text"=> "Terupdate ID >>KOSONG<<{$this->session->get('update')}\n\n{$implode}\n\n Masukan id kemabli atau -selesai-","size"=> "md","weight"=> "bold","wrap"=> true))),
															'footer'=>array("type"=> "box","layout"=> "vertical","spacing"=> "sm","contents"=> array(
																array(
																"type"=> "button","action"=> array( "type"=> "message", "label"=> "selesai",  "text"=> "selesai"),
																	"color"=> "#CC3E16",
																	"style"=> "primary" )
																	)
															) 
														)
													);

													break;
												case 'ready':
													$msg[] = array(
														"type"=> "flex",
														"altText"=> "Flex Message",
														"contents" => array("type"=>"bubble","body"=>array("type"=> "box","layout"=> "vertical","spacing"=> "sm","contents"=> array(
																array("type"=> "text","text"=> "Terupdate ID >>>READY<<<: {$this->session->get('update')} \n\n Masukan id kemabli atau -selesai-","size"=> "md","weight"=> "bold","wrap"=> true))),
															'footer'=>array("type"=> "box","layout"=> "vertical","spacing"=> "sm","contents"=> array(
																array(
																"type"=> "button","action"=> array( "type"=> "message", "label"=> "selesai",  "text"=> "selesai"),
																	"color"=> "#CC3E16",
																	"style"=> "primary" )
																	)
															) 
														)
													);
													break;
												
												
											}
											$this->session->set('update',null);						
											return $msg;
											
										}else
										{
											
											$db = new Database();
											$select = $db->query("SELECT * FROM produks WHERE id = '{$text}'");
											
											$data = $select->fetch_object();
											if($data == null)
											{
												$msg[] = "Kode Tidak Tersedia..Kembali Kerja";
												return $msg;
											}
											$this->session->set('update',$text);
											$msg[] = array('type' => 'template',
																										'altText' => 'confirm play again',
																										'template'=> array(
																											'type'=> 'confirm',
																											'text'=> "Nama :".$data->nama." Ketersediaan sekarang :".$data->ketersediaan,
																											'actions'=> array(
																												array('type'=> 'message','label'=> 'READY','text'=> 'ready'),
																												array('type'=> 'message','label'=> 'KOSONG','text'=> 'kosong')
																												)
																										)
																								);
											return $msg;
										}
										break;
									case 'nota':
										if($text == 'selesai')
										{
												return $this->kerja();
										}
										
										$db = new Database();
										$total = $db->query("select * from total_order where antrian = '{$text}' and tanggal='{$this->session->get('waktu')}'");
										$total_array = $total->fetch_array();
										if($total_array == null)
										{
											$implode = implode("\n",$data);
											$a[] = array(
												"type"=> "flex",
												"altText"=> "Flex Message",
												"contents" => array("type"=>"bubble","body"=>array("type"=> "box","layout"=> "vertical","spacing"=> "sm","contents"=> array(
														array("type"=> "text","text"=> "Data Kosong \n\n 
														\n
														Silahkan masukan no antrian atau -SELESAI-","size"=> "md","weight"=> "bold","wrap"=> true))),
													'footer'=>array("type"=> "box","layout"=> "vertical","spacing"=> "sm","contents"=> array(
														array(
														"type"=> "button","action"=> array( "type"=> "message", "label"=> "Back Work",  "text"=> "selesai"),
															"color"=> "#CC3E16",
															"style"=> "primary" )
															)
													) 
												)
											);
											return $a;
										}
										$select = $db->query("SELECT idproduk from to_order where code ='{$total_array['code']}'");
										$data = array();
										$no = 1;
													foreach($select as $a)
													{
														//array_push($data,$a['id_to']." .".$prod);
														$prod = strtoupper($a['idproduk']);
														array_push($data,$no." ".$prod);
														$no++;
													}
														
													$dataImplode = implode(" \n ",$data);
										//$msg[] = $dataImplode;
										$total = $total_array['total'];
										$msg[] = array(
											"type"=> "flex",
											"altText"=> "Flex Message",
											"contents" => array("type"=>"bubble","body"=>array("type"=> "box","layout"=> "vertical","spacing"=> "sm","contents"=> array(
													array("type"=> "text","text"=> "Pesanan\n {$dataImplode}\n Total :{$total} \n\n Silahkan masukan id atau -selesai-","size"=> "sm","weight"=> "bold","wrap"=> true))),
												'footer'=>array("type"=> "box","layout"=> "vertical","spacing"=> "sm","contents"=> array(
													array(
													"type"=> "button","action"=> array( "type"=> "message", "label"=> "selesai",  "text"=> "selesai"),
														"color"=> "#CC3E16",
														"style"=> "primary" )
														)
														)
													)
												);
											
						
										return $msg;
										break;		
								}
								
							}
						
						}else
						{
							//menu
							switch($text)
							{
								case 'order':
									
									$msg[] = "Hallo bro ".$this->profile->disply_name;
									$msg[] = "Silahkan masukan code ke kode promo";
									$msg[] = "Your code ".rand('4');
									
									return $msg;
									break;
								case 'barista':
									$this->session->set('menu','barista');
									$this->session->set('barista','greating');
									
									$msg[] = "Masukan password password beserta id dipisah menggunakan @ contoh = didin@566";
									return $msg;
									break;
								default:
									//order khusus
									$db = new Database();
									$select = $db->query("SELECT * FROM profiles WHERE user_id = '{$this->profile->user_id}'");		
									$data = $select->fetch_object();
									switch ($data->status) {
										case 'service':
												$db = new Database();
												$query  = $db->query("select * from kerja where tanggal = '{$this->session->get('waktu')}'");
												$query1 = $query->fetch_array();
												
												if($query1['status'] != 'ready')
												{
													$msg[] = "Maaf ibaraki sudah atau sedang tutup";
													$msg[] = "Terimakasih Ibaraki koffie";
													
													return $msg;
												}
												$this->session->set('bar',$query1['userid']);
												if($this->session->get('code') == null)
												{
													$this->session->set('code',rand());
													$this->session->set('nonota',$query1['antrian']);
												}
												
												switch($this->session->get('pilih'))
												{
												case 'pesan':
													switch($text)
													{
														case 'selesai':
															$this->session->set('menu',null);
															$this->session->set('pilih','pesan');					

															$db = new Database();
															$select = $db->query("SELECT idproduk from to_order where code ='{$this->session->get('code')}'");
															$sum = $db->query("SELECT sum(harga) as harga,sum(laba) as laba from to_order where code ='{$this->session->get('code')}'");

															$result_sum = $sum->fetch_array();
															$total =$result_sum['harga'];
															$laba = $result_sum['laba'];

															$total_order = $db->query("insert into total_order(code,user_id,total,laba,tanggal,antrian) 
															values('{$this->session->get('code')}','{$this->profile->user_id}','{$total}',{$laba},'{$this->session->get('waktu')}','{$this->session->get('nonota')}')");

															
															//$m[] = "Terimakasih kunjungan Anda \n".implode("\n",$data)."\n\n"."Total  Rp".$total." No Nota ".$this->session->get('nonota');
															$m[] = array(
																"type"=> "flex",
																"altText"=> "Flex Message",
																"contents" => array("type"=>"bubble","body"=>array("type"=> "box","layout"=> "vertical","spacing"=> "xl","contents"=> array(
																		array("type"=> "text","text"=> "TOTAL :{$total}\n\nAMBIL NO ANTRIAN {$this->session->get('nonota')}","size"=> "xl","weight"=> "bold","wrap"=> true))) 
																)
																);
															$m[] = "Terimakasih.Password wifi : ibarakikoffie225";
															$antrian = $this->session->get('nonota')+1;
															$update = $db->query("update kerja set antrian='{$antrian}' where tanggal = '{$this->session->get('waktu')}'");
															$this->session->set('code',null);

															return $m;
														break;
														case 'salah':
															$this->session->set('pilih','delete');
															$msg[] =strtoupper("Masukan no urut !");
															// $msg[] = array(
															// 	"type"=> "flex",
															// 	"altText"=> "Flex Message",
															// 	"contents" => array("type"=>"bubble","body"=>array("type"=> "box","layout"=> "vertical","spacing"=> "md","contents"=> array(
															// 			array("type"=> "text","text"=> "Silahkan Masukan No Urut ","size"=> "md","weight"=> "bold","wrap"=> true))),
															// 		'footer'=>array("type"=> "box","layout"=> "vertical","spacing"=> "md","contents"=> array(
															// 			array(
															// 			"type"=> "button","action"=> array( "type"=> "message",  "label"=> "-AKHIRI PESANAN-",  "text"=> "selesai"),
															// 				"color"=> "#CC3E16",
															// 				"style"=> "primary" )
															// 				)
															// 		) 
															// 	)
															// 	);
															return $msg;
														break;
														default:
															switch($this->session->get('keadaan'))
															{
																case 'total':
																	$this->session->set('keadaan',null);
																	$implode = $this->total($this->session->get('code'));
																	$m[] = array(
																		"type"=> "flex",
																		"altText"=> "Flex Message",
																		"contents" => array("type"=>"bubble","body"=>array("type"=> "box","layout"=> "vertical","spacing"=> "sm","contents"=> array(
																				array("type"=> "text","text"=> "{$implode}","size"=> "sm","weight"=> "bold","wrap"=> true))),
																			'footer'=>array("type"=> "box","layout"=> "vertical","spacing"=> "sm","contents"=> array(
																				array(
																				"type"=> "button","action"=> array( "type"=> "message",  "label"=> "-HAPUS PESANAN-",  "text"=> "salah"),
																					"color"=> "#CC3E16",
																					"style"=> "primary" ),
																				array(
																				"type"=> "button","action"=> array( "type"=> "message",  "label"=> "-AKHIRI PESANAN-",  "text"=> "selesai"),
																					"color"=> "#16CC3E",
																					"style"=> "primary" )
																					)
																			) 
																		)
																	);
																		
																	return $m;
																break;
																default:
																	$db = new database();	
																	// NEW SISTEM ORDER
																	$select = $db->query("select * from produk where produk.kode ='{$text}'");
																	
																	$data = $select->fetch_object();
																	// BATAS$db = new database();	
																	// NEW SISTEM ORDER
																	$select = $db->query("select * from produk where produk.kode ='{$text}'");
																	
																	$data = $select->fetch_object();
																	// BATAS
																	if($data == null)
																	{
																		if($data->ketersediaan == 'kosong')
																		{
													
																			$implode =  implode("\n",$array);

																			$ksg[] = array(
																			"type"=> "flex",
																			"altText"=> "Flex Message",
																			"contents" => array("type"=>"bubble","body"=>array("type"=> "box","layout"=> "vertical","spacing"=> "sm","contents"=> array(
																					array("type"=> "text","text"=> ">>{$data->nama}<< sedang Tidak tersedia\n\n{$implode}\n DAFTAR MENU YANG TIDAK TERSEDIA\nMasukan yang ID lain atau Akhiri
																					","size"=> "sm","weight"=> "bold","wrap"=> true))),
																				'footer'=>array("type"=> "box","layout"=> "vertical","spacing"=> "sm","contents"=> array(
																					array(
																					"type"=> "button","action"=> array( "type"=> "message",  "label"=> "AKHIRI PESANAN",  "text"=> "selesai"),
																						"color"=> "#CC3E16",
																						"style"=> "primary" )
																						)
																				) 
																			)
																			);
																			return $ksg;
																		}
																		
																	}else
																	{
																		$this->session->set('produk',$data->id);
																		$this->session->set('keadaan','total');
																		$this->session->set('item',$data->name);
																		$subcategori = $db->query("SELECT subcategori.name,subcategori.id 
																		from subcategori,produk_subcategori 
																		where subcategori.id = produk_subcategori.subcategori_id and produk_id = '{$data->id}' ORDER BY subcategori.name
																		");
																		$sub = array();
																		foreach($subcategori as $a)
																		{
																			$data = array("type"=> "button","action"=> array("type"=> "postback","label"=>strtoupper($a['name']),"text"=> $a['name'],"data"=>$a['id']),
																					"height"=> "md");
																			array_push($sub,$data);
																		}

																		return $this->subcategori($sub);
																	}	
															}
													break;

													}
												break;
												case 'delete':
													$this->session->set('pilih','pesan');
													return $this->delete($text,$this->session->get('code'));
												}
											break;
										case 'operator':
											switch ($text) {
												case 'selesai':
													$db = new Database();
													$total_transaksi = $db->query("SELECT * FROM total_order WHERE tanggal = '{$this->session->get('waktu')}' and status ='waiting' limit 2");
								
													if(isset($total_transaksi))
													{
														$data = array();
														foreach($total_transaksi as $a)
														{
																				// REPAIR
																				$select = $db->query("SELECT 
																				id_to,produk.name as name_produk,subcategori.name AS name_subcategori
																				FROM `to_order`,`produk`,`subcategori` WHERE 
																				id_produk = produk.id AND
																				idproduk = subcategori.id AND
																				code ='{$a['code']}' ORDER BY id_to");

																				$sum = $db->query("SELECT sum(harga) as harga from to_order where code ='{$a['code']}'");
																				$result_sum = $sum->fetch_array();

																				$update = $db->query("update total_order set status='done' where code ='{$a['code']}'");
																				$antrian = $a['antrian'];

																				$data = array();
																				$no = 1;
																				foreach($select as $a)
																				{
																					$prod = strtoupper($a['name_produk']." ".$a['name_subcategori']);
																					array_push($data,$no." .".$prod);
																					$no ++;
																				}
																				$dataImplode = implode("\n",$data);
																				$tagihan = "No Nota :".$antrian."\n"."Total :".$result_sum['harga'];
																				$msg[] = array('type' => 'text',
																								'text' => $dataImplode."\n \n"."Tagihan :Rp".$tagihan);
																				$msg[] = array('type' => 'text',
																								'text' =>"=>=>SELANJUTNYA<=<=");
																				}
																						$this->bot->pushMessage($this->session->get('bar'),$msg);
																						$msg[] = array('type' => 'template',
																												'altText' => 'confirm play again',
																												'template'=> array(
																													'type'=> 'confirm',
																													'text'=> 'Selesaikan Pesanan',
																													'actions'=> array(
																														array('type'=> 'message','label'=> 'selesai','text'=> 'SELESAI'),
																														array('type'=> 'message','label'=> 'tutup','text'=> 'TUTUP')
																														)
																												)
																										);
															
																			}else
																				{

																			$msg[] = array('type' => 'template',
																												'altText' => 'confirm play again',
																												'template'=> array(
																													'type'=> 'confirm',
																													'text'=> 'Tidak ada pelanggan',
																													'actions'=> array(
																														array('type'=> 'message','label'=> 'selesai','text'=> 'SELESAI'),
																														array('type'=> 'message','label'=> 'tutup','text'=> 'TUTUP')
																														)
																												)
																										);
																			return $msg;
																			}	
																			return $msg;
																		
																	break;
		
												default:
													$db = new Database();
													$total = $db->query("select * from total_order where antrian = '{$text}' and tanggal='{$this->session->get('waktu')}'");
													$total_array = $total->fetch_array();
													if($total_array == null)
													{
														
														return "No Antrian Salah";	
													}
													$m[] = $this->total($total_array['code']);
													$m[] = "Total Rp. ".$total_array['total'];
													return $m;
													break;
											}
										break;
									}		
									
							}
							$msg[] = "Maaf menu tidak tersedia";
							return $msg;
						}					
					}
					
					function on_postback($data)
					{
						$db = new database();
						// $value1 = "This id".$this->session->get('produk')."This data ".$data ;
						$produk_subcategori = $db->query("SELECT * FROM `produk_subcategori` 
														WHERE produk_id = '{$this->session->get('produk')}' 
														AND subcategori_id = '{$data}' ");
						$ps = $produk_subcategori->fetch_object();
						// $value = "This harga".$ps->harga."This laba ".$ps->laba ;
						$select = $db->query("select * from to_order where code = '{$this->session->get('code')}' order by id_to desc limit 1");
						$orders = $select->fetch_array();
						
						if($orders['id_to'] == null)
						{
							$insert = $db->query("INSERT INTO to_order(id_to,idproduk,harga,laba,code,tanggal,antrian,id_produk) 
							VALUES('1','$ps->subcategori_id',
							'$ps->harga','$ps->laba','{$this->session->get('code')}',
							'{$this->session->get('waktu')}','{$this->session->get('nonota')}','$ps->produk_id')");

						}else
						{
							$no = $orders['id_to']+1;
							$insert = $db->query("INSERT INTO to_order(id_to,idproduk,harga,laba,code,tanggal,antrian,id_produk) 
							VALUES('$no','$ps->subcategori_id',
							'$ps->harga','$ps->laba','{$this->session->get('code')}',
							'{$this->session->get('waktu')}','{$this->session->get('nonota')}','$ps->produk_id')");
						}
					}
					private function total($code)
					{
						$db = new database();
						$selects = $db->query("SELECT 
						id_to,produk.name as name_produk,subcategori.name AS name_subcategori
						FROM `to_order`,`produk`,`subcategori` WHERE 
						id_produk = produk.id AND
						idproduk = subcategori.id AND
						code ='{$code}' ORDER BY id_to");
						$data = array();
						$a = array();
						foreach($selects as $a)
						{
							$prod = strtoupper($a['name_produk']." ".$a['name_subcategori']);
							array_push($data,$a['id_to']." .".$prod);
						}
														
						//$m[]= 'mendem';
						return $implode =  implode("\n",$data);
					}
					private function total_buy(){
						$db = new database();
						$selects = $db->query("SELECT 
						id_to,produk.name as name_produk,subcategori.name AS name_subcategori
						FROM `to_order`,`produk`,`subcategori` WHERE 
						id_produk = produk.id AND
						idproduk = subcategori.id AND
						code ='{$this->session->get('code')}' ORDER BY id_to");
						$data = array();
						$a = array();
						foreach($selects as $a)
						{
							$prod = strtoupper($a['name_produk']." ".$a['name_subcategori']);
							array_push($data,$a['id_to']." .".$prod);
						}
														
						//$m[]= 'mendem';
						$implode =  implode("\n",$data);
						$m[] = array(
							"type"=> "flex",
							"altText"=> "Flex Message",
							"contents" => array("type"=>"bubble","body"=>array("type"=> "box","layout"=> "vertical","spacing"=> "sm","contents"=> array(
									array("type"=> "text","text"=> "{$implode}","size"=> "sm","weight"=> "bold","wrap"=> true))),
								'footer'=>array("type"=> "box","layout"=> "vertical","spacing"=> "sm","contents"=> array(
									array(
									"type"=> "button","action"=> array( "type"=> "message",  "label"=> "-HAPUS PESANAN-",  "text"=> "salah"),
										"color"=> "#CC3E16",
										"style"=> "primary" ),
									array(
									"type"=> "button","action"=> array( "type"=> "message",  "label"=> "-AKHIRI PESANAN-",  "text"=> "selesai"),
										"color"=> "#16CC3E",
										"style"=> "primary" )
										)
								) 
							)
						);
							
						return $m;								
					}
					private function subcategori($array)
					{
						$salah = array("type"=> "button",
										"action"=> array(
											"type"=> "message",
											"label"=> "BATAL",
											"text"=> "batal"));
						array_push($array,$salah);
							$x = array(
								"type" => "flex",
								"altText"=> "Flex Message",
								"contents"=> array(
								  "type"=> "bubble",
								  "body"=> array(
									"type"=> "box",
									"layout"=> "vertical",
									"contents"=> array(
									  array(
										"type"=> "text",
										"text"=> $this->session->get('item')
										)
									 )
								  ),
								  "footer"=> array(
									"type"=> "box",
									"layout"=> "vertical",
									"flex"=> 0,
									"spacing"=> "sm",
									"contents"=> $array
									)
								 )
							  );
						return $x;
					}
					private function insert()
					{
						$db = new database();
						$select = $db->query("select * from to_order where code = '{$this->session->get('code')}' order by id_to desc limit 1");
						
						$orders = $select->fetch_array();
						
						if($orders['id_to'] == null)
						{
							$insert = $db->query("INSERT INTO to_order(id_to,idproduk,harga,laba,code,tanggal,antrian,id_produk) 
							VALUES('1','{$this->session->get('item')}',
							'{$this->session->get('harga')}',{$this->session->get('laba')},'{$this->session->get('code')}',
							'{$this->session->get('waktu')}','{$this->session->get('nonota')}','{$this->session->get('idproduk')}')");

						}else
						{
							$no = $orders['id_to']+1;
							$insert = $db->query("INSERT INTO to_order(id_to,idproduk,harga,laba,code,tanggal,antrian,id_produk) 
							VALUES('$no','{$this->session->get('item')}',
							'{$this->session->get('harga')}',{$this->session->get('laba')},'{$this->session->get('code')}',
							'{$this->session->get('waktu')}','{$this->session->get('nonota')}','{$this->session->get('idproduk')}')");
						}
						
						$selects = $db->query("SELECT * from to_order where code ='{$this->session->get('code')}'");
						$data = array();
						$a = array();
						foreach($selects as $a)
						{
							$prod = strtoupper($a['idproduk']);
							array_push($data,$a['id_to']." .".$prod);
						}
						
						//$m[]= 'mendem';
						$implode =  implode("\n",$data);
						$m[] = array(
															"type"=> "flex",
															"altText"=> "Flex Message",
															"contents" => array("type"=>"bubble","body"=>array("type"=> "box","layout"=> "vertical","spacing"=> "sm","contents"=> array(
																	array("type"=> "text","text"=> "{$implode}","size"=> "sm","weight"=> "bold","wrap"=> true))),
																'footer'=>array("type"=> "box","layout"=> "vertical","spacing"=> "sm","contents"=> array(
																	array(
																	"type"=> "button","action"=> array( "type"=> "message",  "label"=> "-APA PESANAN SALAH ??-",  "text"=> "salah"),
																		"color"=> "#CC3E16",
																		"style"=> "primary" ),
																	array(
																	"type"=> "button","action"=> array( "type"=> "message",  "label"=> "-AKHIRI PESANAN-",  "text"=> "selesai"),
																		"color"=> "#16CC3E",
																		"style"=> "primary" )
																		)
																) 
															)
														);
															
						return $m;	
					}
					private function kerja()
					{
							$this->session->set('barista','kerja');
							$ksg[] = array(
								"type"=> "flex",
								"altText"=> "Flex Message",
								"contents" => array("type"=>"bubble","body"=>array("type"=> "box","layout"=> "vertical","spacing"=> "sm","contents"=> array(
										array("type"=> "text","text"=> "Silahkan Reload untuk pesanan","size"=> "sm","weight"=> "bold","wrap"=> true))),
									'footer'=>array("type"=> "box","layout"=> "vertical","spacing"=> "sm","contents"=> array(
										array(
										"type"=> "button","action"=> array( "type"=> "message", "label"=> "Reload",  "text"=> "selesai"),
											"color"=> "#CC3E16",
											"style"=> "primary" )
											)
									) 
								)
							);
							return $ksg;
					}
					private function deleteProd($id,$code)
					{
						
						$db = new database();
						$delete = $db->query("delete from to_order where id_produk= '{$id}' and code = '$code'");
					}
					private function delete($id,$code)
					{
						
						$db = new database();
						$delete = $db->query("delete from to_order where id_to = '{$id}' and code = '$code'");
						if(is_null($delete))
						{
							return "No yang anda inputkan tidak ada";
						}
						$update = $db->query("SELECT * from to_order where code ='$code'");
						$no = 1;
						foreach($update as $a)
						{
							$update = $db->query("UPDATE to_order SET id_to = '{$no}' WHERE id_to='{$a['id_to']}' and code ='$code'");
							$no++;
						}
						$implode =  $this->total($code);
						$m[] = array(
							"type"=> "flex",
							"altText"=> "Flex Message",
							"contents" => array("type"=>"bubble","body"=>array("type"=> "box","layout"=> "vertical","spacing"=> "sm","contents"=> array(
									array("type"=> "text","text"=> "{$implode}","size"=> "sm","weight"=> "bold","wrap"=> true))),
								'footer'=>array("type"=> "box","layout"=> "vertical","spacing"=> "sm","contents"=> array(
									array(
									"type"=> "button","action"=> array( "type"=> "message",  "label"=> "-HAPUS PESANAN-",  "text"=> "salah"),
										"color"=> "#CC3E16",
										"style"=> "primary" ),
									array(
									"type"=> "button","action"=> array( "type"=> "message",  "label"=> "-AKHIRI PESANAN-",  "text"=> "selesai"),
										"color"=> "#16CC3E",
										"style"=> "primary" )
										)
								) 
							)
						);
							
						return $m;	
						
					}
				}

			?>