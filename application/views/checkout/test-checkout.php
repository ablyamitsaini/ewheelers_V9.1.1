<section class="section bg-gray-dark">
	<div class="container">

		<div class="row justify-content-between">
			<div class="col-lg-8 col-md-8 mb-4 mb-md-0">
				<div class="section-head">
					<div class="section__heading">
						<h2>Shipping/Billing Address</h2>
					</div>
				</div>
				<div class="box box--white box--radius p-4">
					<section id="billing" class="section-checkout">
						<div class="section-head">
							<div class="section__heading">
								<h6>Add Address</h6>
							</div>
						</div>
						<form name="frmAddress" method="post" id="frm_fat_id_frmAddress" class="form form--normal" onsubmit="setUpAddress(this); return(false);">
							<div class="row">
								<div class="col-md-6">
									<div class="field-set">
										<div class="caption-wraper"><label class="field_label">Address Label</label></div>
										<div class="field-wraper">
											<div class="field_cover"><input placeholder="E.g: My Office Address" title="Address Label" data-fatreq="{&quot;required&quot;:false}" type="text" name="ua_identifier" value="Ablysoft"></div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="field-set">
										<div class="caption-wraper"><label class="field_label">Name<span class="spn_must_field">*</span></label></div>
										<div class="field-wraper">
											<div class="field_cover"><input title="Name" data-fatreq="{&quot;required&quot;:true}" type="text" name="ua_name" value="Kanwar"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="field-set">
										<div class="caption-wraper"><label class="field_label">Address Line1<span class="spn_must_field">*</span></label></div>
										<div class="field-wraper">
											<div class="field_cover"><input title="Address Line1" data-fatreq="{&quot;required&quot;:true}" type="text" name="ua_address1" value="Plot no 268, JLPL industrial area, Sector 82"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="field-set">
										<div class="caption-wraper"><label class="field_label">Address Line2</label></div>
										<div class="field-wraper">
											<div class="field_cover"><input title="Address Line2" data-fatreq="{&quot;required&quot;:false}" type="text" name="ua_address2" value="Mohali"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="field-set">
										<div class="caption-wraper"><label class="field_label">Country<span class="spn_must_field">*</span></label></div>
										<div class="field-wraper">
											<div class="field_cover"><select id="ua_country_id" onchange="getCountryStates(this.value, 0 ,'#ua_state_id')" title="Country" data-fatreq="{&quot;required&quot;:true}" name="ua_country_id">
													<option value="">Select</option>
													<option value="244">Aaland Islands</option>
													<option value="1">Afghanistan</option>
													<option value="2">Albania</option>
													<option value="3">Algeria</option>
													<option value="4">American Samoa</option>
													<option value="5">Andorra</option>
													<option value="6">Angola</option>
													<option value="7">Anguilla</option>
													<option value="8">Antarctica</option>
													<option value="9">Antigua and Barbuda</option>
													<option value="10">Argentina</option>
													<option value="11">Armenia</option>
													<option value="12">Aruba</option>
													<option value="13">Australia</option>
													<option value="14">Austria</option>
													<option value="15">Azerbaijan</option>
													<option value="16">Bahamas</option>
													<option value="17">Bahrain</option>
													<option value="18">Bangladesh</option>
													<option value="19">Barbados</option>
													<option value="20">Belarus</option>
													<option value="21">Belgium</option>
													<option value="22">Belize</option>
													<option value="23">Benin</option>
													<option value="24">Bermuda</option>
													<option value="25">Bhutan</option>
													<option value="26">Bolivia</option>
													<option value="245">Bonaire, Sint Eustatius and Saba</option>
													<option value="27">Bosnia and Herzegovina</option>
													<option value="28">Botswana</option>
													<option value="29">Bouvet Island</option>
													<option value="30">Brazil</option>
													<option value="31">British Indian Ocean Territory</option>
													<option value="32">Brunei Darussalam</option>
													<option value="33">Bulgaria</option>
													<option value="34">Burkina Faso</option>
													<option value="35">Burundi</option>
													<option value="36">Cambodia</option>
													<option value="37">Cameroon</option>
													<option value="38">Canada</option>
													<option value="251">Canary Islands</option>
													<option value="39">Cape Verde</option>
													<option value="40">Cayman Islands</option>
													<option value="41">Central African Republic</option>
													<option value="42">Chad</option>
													<option value="43">Chile</option>
													<option value="44">China</option>
													<option value="45">Christmas Island</option>
													<option value="46">Cocos (Keeling) Islands</option>
													<option value="47">Colombia</option>
													<option value="48">Comoros</option>
													<option value="49">Congo</option>
													<option value="50">Cook Islands</option>
													<option value="51">Costa Rica</option>
													<option value="52">Cote D'Ivoire</option>
													<option value="53">Croatia</option>
													<option value="54">Cuba</option>
													<option value="246">Curacao</option>
													<option value="55">Cyprus</option>
													<option value="56">Czech Republic</option>
													<option value="237">Democratic Republic of Congo</option>
													<option value="57">Denmark</option>
													<option value="58">Djibouti</option>
													<option value="59">Dominica</option>
													<option value="60">Dominican Republic</option>
													<option value="61">East Timor</option>
													<option value="62">Ecuador</option>
													<option value="63">Egypt</option>
													<option value="64">El Salvador</option>
													<option value="65">Equatorial Guinea</option>
													<option value="66">Eritrea</option>
													<option value="67">Estonia</option>
													<option value="68">Ethiopia</option>
													<option value="69">Falkland Islands (Malvinas)</option>
													<option value="70">Faroe Islands</option>
													<option value="71">Fiji</option>
													<option value="72">Finland</option>
													<option value="74">France, Metropolitan</option>
													<option value="75">French Guiana</option>
													<option value="76">French Polynesia</option>
													<option value="77">French Southern Territories</option>
													<option value="126">FYROM</option>
													<option value="78">Gabon</option>
													<option value="79">Gambia</option>
													<option value="80">Georgia</option>
													<option value="81">Germany</option>
													<option value="82">Ghana</option>
													<option value="83">Gibraltar</option>
													<option value="84">Greece</option>
													<option value="85">Greenland</option>
													<option value="86">Grenada</option>
													<option value="87">Guadeloupe</option>
													<option value="88">Guam</option>
													<option value="89">Guatemala</option>
													<option value="241">Guernsey</option>
													<option value="90">Guinea</option>
													<option value="91">Guinea-Bissau</option>
													<option value="92">Guyana</option>
													<option value="93">Haiti</option>
													<option value="94">Heard and Mc Donald Islands</option>
													<option value="95">Honduras</option>
													<option value="96">Hong Kong</option>
													<option value="97">Hungary</option>
													<option value="98">Iceland</option>
													<option value="99" selected="selected">India</option>
													<option value="100">Indonesia</option>
													<option value="101">Iran (Islamic Republic of)</option>
													<option value="102">Iraq</option>
													<option value="103">Ireland</option>
													<option value="104">Israel</option>
													<option value="105">Italy</option>
													<option value="106">Jamaica</option>
													<option value="107">Japan</option>
													<option value="240">Jersey</option>
													<option value="108">Jordan</option>
													<option value="109">Kazakhstan</option>
													<option value="110">Kenya</option>
													<option value="111">Kiribati</option>
													<option value="113">Korea, Republic of</option>
													<option value="114">Kuwait</option>
													<option value="115">Kyrgyzstan</option>
													<option value="116">Lao People's Democratic Republic</option>
													<option value="117">Latvia</option>
													<option value="118">Lebanon</option>
													<option value="119">Lesotho</option>
													<option value="120">Liberia</option>
													<option value="121">Libyan Arab Jamahiriya</option>
													<option value="122">Liechtenstein</option>
													<option value="123">Lithuania</option>
													<option value="124">Luxembourg</option>
													<option value="125">Macau</option>
													<option value="127">Madagascar</option>
													<option value="128">Malawi</option>
													<option value="129">Malaysia</option>
													<option value="130">Maldives</option>
													<option value="131">Mali</option>
													<option value="132">Malta</option>
													<option value="133">Marshall Islands</option>
													<option value="134">Martinique</option>
													<option value="135">Mauritania</option>
													<option value="136">Mauritius</option>
													<option value="137">Mayotte</option>
													<option value="138">Mexico</option>
													<option value="139">Micronesia, Federated States of</option>
													<option value="140">Moldova, Republic of</option>
													<option value="141">Monaco</option>
													<option value="142">Mongolia</option>
													<option value="242">Montenegro</option>
													<option value="143">Montserrat</option>
													<option value="144">Morocco</option>
													<option value="145">Mozambique</option>
													<option value="146">Myanmar</option>
													<option value="147">Namibia</option>
													<option value="148">Nauru</option>
													<option value="149">Nepal</option>
													<option value="150">Netherlands</option>
													<option value="151">Netherlands Antilles</option>
													<option value="152">New Caledonia</option>
													<option value="153">New Zealand</option>
													<option value="154">Nicaragua</option>
													<option value="155">Niger</option>
													<option value="156">Nigeria</option>
													<option value="157">Niue</option>
													<option value="158">Norfolk Island</option>
													<option value="112">North Korea</option>
													<option value="159">Northern Mariana Islands</option>
													<option value="160">Norway</option>
													<option value="161">Oman</option>
													<option value="162">Pakistan</option>
													<option value="163">Palau</option>
													<option value="247">Palestinian Territory, Occupied</option>
													<option value="164">Panama</option>
													<option value="165">Papua New Guinea</option>
													<option value="166">Paraguay</option>
													<option value="167">Peru</option>
													<option value="168">Philippines</option>
													<option value="169">Pitcairn</option>
													<option value="170">Poland</option>
													<option value="171">Portugal</option>
													<option value="172">Puerto Rico</option>
													<option value="173">Qatar</option>
													<option value="174">Reunion</option>
													<option value="175">Romania</option>
													<option value="176">Russian Federation</option>
													<option value="177">Rwanda</option>
													<option value="178">Saint Kitts and Nevis</option>
													<option value="179">Saint Lucia</option>
													<option value="180">Saint Vincent and the Grenadines</option>
													<option value="181">Samoa</option>
													<option value="182">San Marino</option>
													<option value="183">Sao Tome and Principe</option>
													<option value="184">Saudi Arabia</option>
													<option value="185">Senegal</option>
													<option value="243">Serbia</option>
													<option value="186">Seychelles</option>
													<option value="187">Sierra Leone</option>
													<option value="188">Singapore</option>
													<option value="189">Slovak Republic</option>
													<option value="190">Slovenia</option>
													<option value="191">Solomon Islands</option>
													<option value="192">Somalia</option>
													<option value="193">South Africa</option>
													<option value="194">South Georgia &amp;amp; South Sandwich Islands</option>
													<option value="248">South Sudan</option>
													<option value="195">Spain</option>
													<option value="196">Sri Lanka</option>
													<option value="249">St. Barthelemy</option>
													<option value="197">St. Helena</option>
													<option value="250">St. Martin (French part)</option>
													<option value="198">St. Pierre and Miquelon</option>
													<option value="199">Sudan</option>
													<option value="200">Suriname</option>
													<option value="201">Svalbard and Jan Mayen Islands</option>
													<option value="202">Swaziland</option>
													<option value="203">Sweden</option>
													<option value="204">Switzerland</option>
													<option value="205">Syrian Arab Republic</option>
													<option value="206">Taiwan</option>
													<option value="207">Tajikistan</option>
													<option value="208">Tanzania, United Republic of</option>
													<option value="209">Thailand</option>
													<option value="210">Togo</option>
													<option value="211">Tokelau</option>
													<option value="212">Tonga</option>
													<option value="213">Trinidad and Tobago</option>
													<option value="214">Tunisia</option>
													<option value="215">Turkey</option>
													<option value="216">Turkmenistan</option>
													<option value="217">Turks and Caicos Islands</option>
													<option value="218">Tuvalu</option>
													<option value="219">Uganda</option>
													<option value="220">Ukraine</option>
													<option value="221">United Arab Emirates</option>
													<option value="222">United Kingdom</option>
													<option value="223">United States</option>
													<option value="224">United States Minor Outlying Islands</option>
													<option value="225">Uruguay</option>
													<option value="226">Uzbekistan</option>
													<option value="227">Vanuatu</option>
													<option value="228">Vatican City State (Holy See)</option>
													<option value="229">Venezuela</option>
													<option value="230">Viet Nam</option>
													<option value="231">Virgin Islands (British)</option>
													<option value="232">Virgin Islands (U.S.)</option>
													<option value="233">Wallis and Futuna Islands</option>
													<option value="234">Western Sahara</option>
													<option value="235">Yemen</option>
													<option value="238">Zambia</option>
													<option value="239">Zimbabwe</option>
												</select></div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="field-set">
										<div class="caption-wraper"><label class="field_label">State<span class="spn_must_field">*</span></label></div>
										<div class="field-wraper">
											<div class="field_cover"><select id="ua_state_id" title="State" data-fatreq="{&quot;required&quot;:true}" name="ua_state_id">
													<option value="">Select State</option>
													<option value="1267">Andaman and Nicobar</option>
													<option value="1268">Andhra Pradesh</option>
													<option value="1269">Arunachal Pradesh</option>
													<option value="1270">Assam</option>
													<option value="1271">Bihar</option>
													<option value="1272">Chandigarh</option>
													<option value="1273">Chhattisgarh</option>
													<option value="1274">Dadra and Nagar Haveli</option>
													<option value="1275">Daman and Diu</option>
													<option value="1276">Delhi</option>
													<option value="1277">Goa</option>
													<option value="1278">Gujarat</option>
													<option value="1279">Haryana</option>
													<option value="1280">Himachal Pradesh</option>
													<option value="1281">Jammu and Kashmir</option>
													<option value="1282">Jharkand</option>
													<option value="1283">Karnataka</option>
													<option value="1284">Kerala</option>
													<option value="1285">Lakshadeep</option>
													<option value="1286">Madhya Pradesh</option>
													<option value="1287">Maharashtra</option>
													<option value="1288">Manipur</option>
													<option value="1289">Meghalaya</option>
													<option value="1290">Mizoram</option>
													<option value="1291">Nagaland</option>
													<option value="1292">Orissa</option>
													<option value="1302">Others</option>
													<option value="1293">Pondicherry</option>
													<option value="1294" selected="">Punjab</option>
													<option value="1295">Rajasthan</option>
													<option value="1296">Sikkim</option>
													<option value="1297">Tamil Nadu</option>
													<option value="1298">Tripura</option>
													<option value="1299">Uttar Pradesh</option>
													<option value="1300">Uttaranchal</option>
													<option value="1301">West Bengal</option>
												</select></div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="field-set">
										<div class="caption-wraper"><label class="field_label">City<span class="spn_must_field">*</span></label></div>
										<div class="field-wraper">
											<div class="field_cover"><input title="City" data-fatreq="{&quot;required&quot;:true}" type="text" name="ua_city" value="mohali"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="field-set">
										<div class="caption-wraper"><label class="field_label">Postalcode<span class="spn_must_field">*</span></label></div>
										<div class="field-wraper">
											<div class="field_cover"><input title="Postalcode" data-fatreq="{&quot;required&quot;:true}" type="text" name="ua_zip" value="160055"></div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="field-set">
										<div class="caption-wraper"><label class="field_label">Phone<span class="spn_must_field">*</span></label></div>
										<div class="field-wraper">
											<div class="field_cover"><input title="Phone" data-fatreq="{&quot;required&quot;:true}" type="text" name="ua_phone" value="6867456"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="row justify-content-between">
								<div class="col"><input onclick="resetAddress()" title="" data-fatreq="{&quot;required&quot;:false}" type="button" name="btn_cancel" value="Cancel" class="btn btn--primary-border"> </div>
								<div class="col-auto">
									<input title="" data-fatreq="{&quot;required&quot;:false}" class="btn btn--primary" type="submit" name="btn_submit" value="Save Changes">
								</div>
							</div><input title="" data-fatreq="{&quot;required&quot;:false}" type="hidden" name="ua_id" value="2">
						</form>

					</section>
				</div>
				<div class="section-head">
					<div class="section__heading">
						<h2>Delivery Options</h2>
					</div>
				</div>
				<div class="box box--white box--radius p-4">
					<section id="shipping-summary" class="section-checkout">
						<div class="short-detail">
							<div class="shipping-seller">
								<div class="row  justify-content-between">
									<div class="col-auto">
										<div class="shipping-seller-title">Kanwar's Shop</div>
									</div>
									<div class="col-auto"></div>
								</div>
								<table class="cart-summary table table--justify  js-scrollable">
									<tbody>
										<tr class="">
											<td>
												<figure class="item__pic"><a href="/candle-ankle-formal-shoes-110"><img src="../image/product/44/THUMB/110/0/1" alt="Candle Ankle Formal Shoes" title="Candle Ankle Formal Shoes"></a></figure>
											</td>
											<td>
												<div class="item__description">
													<div class="item__category">Shop: <span class="text--dark">Kanwar's Shop</span></div>
													<div class="item__title"><a title="Candle Leather High Ankel Shoes Lace Up (Black)" href="/candle-ankle-formal-shoes-110">Candle Leather High Ankel Shoes Lace Up (Black)</a></div>
													<div class="item__specification">
														| Size: <span class="text--dark">7</span>
														| Quantity 1 </div>
												</div>
											</td>
											<td>
												<ul class="shipping-selectors">
													<li><select name="shipping_type[2e7cf7211f38deb8dc6de87a50c55867]" class="shipping_method" data-product-key="2e7cf7211f38deb8dc6de87a50c55867">
															<option value="0">Select Shipping Method</option>
															<option selected="selected" value="1">Flat Shipping By Seller</option>
															<option value="2">ShipStation Api</option>
														</select></li>
													<li class="manual_shipping" style="display:block">

														<select name="shipping_locations[2e7cf7211f38deb8dc6de87a50c55867]">
															<option value="0">Select Shipping</option>
															<option selected="selected" value="192">DHL - 1 to 9 Business Days (+ $11.00)</option>
															<option value="193">UPS - 1 to 6 Business Days (+ $11.00)</option>
														</select> </li>
													<li class="shipstation_selectbox" style="display:none">
														Select Shipping Provider <select name="shipping_carrier[2e7cf7211f38deb8dc6de87a50c55867]" class="courier_carriers" onchange="loadShippingCarriers(this);" data-product-key="2e7cf7211f38deb8dc6de87a50c55867">
															<option selected="selected" value="0">Select Services</option>
															<option value="ups">UPS</option>
															<option value="fedex">FedEx</option>
														</select> </li>
													<li class="shipstation_selectbox" style="display:none">
														Select Shipping Carrier <div class="services_loader"></div>
														<select name="shipping_services[2e7cf7211f38deb8dc6de87a50c55867]" class="courier_services "></select> </li>
												</ul>
											</td>
											<td><span class="item__price"> $75.00 </span>
												<span class="text--normal text--normal-primary">-6%</span>
											</td>
											<td class="text-right">
												<a href="javascript:void(0)" onclick="cart.remove('2e7cf7211f38deb8dc6de87a50c55867','checkout')" class="icons-wrapper"><i class="icn"><svg class="svg">
															<use xlink:href="../images/retina/sprite.svg#bin" href="../images/retina/sprite.svg#bin"></use>
														</svg></i></a>
											</td>
										</tr>
										<tr class="">
											<td>
												<figure class="item__pic"><a href="/candle-ankle-formal-shoes-110"><img src="../image/product/44/THUMB/110/0/1" alt="Candle Ankle Formal Shoes" title="Candle Ankle Formal Shoes"></a></figure>
											</td>
											<td>
												<div class="item__description">
													<div class="item__category">Shop: <span class="text--dark">Kanwar's Shop</span></div>
													<div class="item__title"><a title="Candle Leather High Ankel Shoes Lace Up (Black)" href="/candle-ankle-formal-shoes-110">Candle Leather High Ankel Shoes Lace Up (Black)</a></div>
													<div class="item__specification">
														| Size: <span class="text--dark">7</span>
														| Quantity 1 </div>
												</div>
											</td>
											<td>
												<ul class="shipping-selectors">
													<li><select name="shipping_type[2e7cf7211f38deb8dc6de87a50c55867]" class="shipping_method" data-product-key="2e7cf7211f38deb8dc6de87a50c55867">
															<option value="0">Select Shipping Method</option>
															<option selected="selected" value="1">Flat Shipping By Seller</option>
															<option value="2">ShipStation Api</option>
														</select></li>
													<li class="manual_shipping" style="display:block">

														<select name="shipping_locations[2e7cf7211f38deb8dc6de87a50c55867]">
															<option value="0">Select Shipping</option>
															<option selected="selected" value="192">DHL - 1 to 9 Business Days (+ $11.00)</option>
															<option value="193">UPS - 1 to 6 Business Days (+ $11.00)</option>
														</select> </li>
													<li class="shipstation_selectbox" style="display:none">
														Select Shipping Provider <select name="shipping_carrier[2e7cf7211f38deb8dc6de87a50c55867]" class="courier_carriers" onchange="loadShippingCarriers(this);" data-product-key="2e7cf7211f38deb8dc6de87a50c55867">
															<option selected="selected" value="0">Select Services</option>
															<option value="ups">UPS</option>
															<option value="fedex">FedEx</option>
														</select> </li>
													<li class="shipstation_selectbox" style="display:none">
														Select Shipping Carrier <div class="services_loader"></div>
														<select name="shipping_services[2e7cf7211f38deb8dc6de87a50c55867]" class="courier_services "></select> </li>
												</ul>
											</td>
											<td><span class="item__price"> $75.00 </span>
												<span class="text--normal text--normal-primary">-6%</span>
											</td>
											<td class="text-right">
												<a href="javascript:void(0)" onclick="cart.remove('2e7cf7211f38deb8dc6de87a50c55867','checkout')" class="icons-wrapper"><i class="icn"><svg class="svg">
															<use xlink:href="../images/retina/sprite.svg#bin" href="../images/retina/sprite.svg#bin"></use>
														</svg></i></a>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</section>
				</div>
				<div class="section-head">
					<div class="section__heading">
						<h2>Payment</h2>
					</div>
				</div>
				<div class="box box--white box--radius p-4">
					<section id="payment" class="section-checkout">
						<div class="section-head">
							<div class="section__heading">
								<h6>Reward Point In Your Account <strong>538</strong>( $269.00) You Can Use Upto <strong>538</strong></h6>
							</div>
						</div>

						<div class="row align-items-center mb-4">
							<div class="col">
								<form name="frmRewards" method="post" id="frm_fat_id_frmRewards" class="form form--secondary form--singlefield" onsubmit="useRewardPoints(this); return false;"><input placeholder="Use Reward Point" data-field-caption="Reward Points" data-fatreq="{&quot;required&quot;:true}" type="text" name="redeem_rewards" value=""><input data-field-caption="" data-fatreq="{&quot;required&quot;:false}" type="submit" name="btn_submit" value="Apply">
								</form>
							</div>
							<div class="col-auto">
								<div id="wallet" class="wallet">
									<label class="checkbox brand" id="brand_95"><input onchange="walletSelection(this)" type="checkbox" name="pay_from_wallet" id="pay_from_wallet"><i class="input-helper"></i><strong>Use My Wallet Credits: ( $2,818.56)</strong>
									</label>
								</div>
							</div>
						</div>



						<div class="payment_methods_list mb-4">
							<ul id="payment_methods_tab" class="simplebar-horizontal" data-simplebar>
								<li class="is-active">
									<a href="/checkout/payment-tab/O1556972536/5">
										<div class="payment-box">
											<i class="payment-icn"> <img src="../images/paypal.png" alt=""> </i><span>Stripe</span></div>
									</a>
								</li>

								<li class="">
									<a href="/checkout/payment-tab/O1556972536/5">
										<div class="payment-box">
											<i class="payment-icn"> <img src="../images/paypal.png" alt=""> </i><span>Stripe</span></div>
									</a>
								</li>
								<li class="">
									<a href="/checkout/payment-tab/O1556972536/5">
										<div class="payment-box">
											<i class="payment-icn"> <img src="../images/paypal.png" alt=""> </i><span>Stripe</span></div>
									</a>
								</li>
								<li class="">
									<a href="/checkout/payment-tab/O1556972536/5">
										<div class="payment-box">
											<i class="payment-icn"> <img src="../images/paypal.png" alt=""> </i><span>Stripe</span></div>
									</a>
								</li>
								<li class="">
									<a href="/checkout/payment-tab/O1556972536/5">
										<div class="payment-box">
											<i class="payment-icn"> <img src="../images/paypal.png" alt=""> </i><span>Stripe</span></div>
									</a>
								</li>
								<li class="">
									<a href="/checkout/payment-tab/O1556972536/5">
										<div class="payment-box">
											<i class="payment-icn"> <img src="../images/paypal.png" alt=""> </i><span>Stripe</span></div>
									</a>
								</li>
								<li class="">
									<a href="/checkout/payment-tab/O1556972536/5">
										<div class="payment-box">
											<i class="payment-icn"> <img src="../images/paypal.png" alt=""> </i><span>Stripe</span></div>
									</a>
								</li>
								<li class="">
									<a href="/checkout/payment-tab/O1556972536/5">
										<div class="payment-box">
											<i class="payment-icn"> <img src="../images/paypal.png" alt=""> </i><span>Stripe</span></div>
									</a>
								</li>
							</ul>

						</div>
						<div class="payment-from">
							<form id="frmPaymentForm" action="/authorize-aim-pay/send/O1557124055" class="form form--payment p-4" name="frmPaymentForm" method="post" onsubmit="sendPayment(this); return(false);">
								<div class="row">
									<div class="col-md-12">
										<div class="field-set">
											<div class="caption-wraper">
												<label class="field_label">Enter Credit Card Number</label>
											</div>
											<div class="field-wraper">
												<div class="field_cover"> <input class="p-cards" id="cc_number" data-field-caption="Enter Credit Card Number" data-fatreq="{&quot;required&quot;:true}" type="text" name="cc_number" value=""> </div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="field-set">
											<div class="caption-wraper">
												<label class="field_label">Card Holder Name</label>
											</div>
											<div class="field-wraper">
												<div class="field_cover"> <input data-field-caption="Card Holder Name" data-fatreq="{&quot;required&quot;:true}" type="text" name="cc_owner" value=""> </div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="caption-wraper">
											<label class="field_label"> Credit Card Expiry </label>
										</div>
										<div class="row">
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
												<div class="field-set">
													<div class="field-wraper">
														<div class="field_cover">
															<select id="ccExpMonth" class="ccExpMonth  combobox required" data-field-caption="Expiry Month" data-fatreq="{&quot;required&quot;:false}" name="cc_expire_date_month">
																<option value="01">January</option>
																<option value="02">Februry</option>
																<option value="03">March</option>
																<option value="04">April</option>
																<option value="05">May</option>
																<option value="06">June</option>
																<option value="07">July</option>
																<option value="08">August</option>
																<option value="09">September</option>
																<option value="10">October</option>
																<option value="11">November</option>
																<option value="12">December</option>
															</select> </div>
													</div>
												</div>
											</div>
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
												<div class="field-set">
													<div class="field-wraper">
														<div class="field_cover">
															<select id="ccExpYear" class="ccExpYear  combobox required" data-field-caption="Expiry Year" data-fatreq="{&quot;required&quot;:false}" name="cc_expire_date_year">
																<option value="2019">2019</option>
																<option value="2020">2020</option>
																<option value="2021">2021</option>
																<option value="2022">2022</option>
																<option value="2023">2023</option>
																<option value="2024">2024</option>
																<option value="2025">2025</option>
																<option value="2026">2026</option>
																<option value="2027">2027</option>
																<option value="2028">2028</option>
																<option value="2029">2029</option>
															</select> </div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="field-set">
											<div class="caption-wraper">
												<label class="field_label">CVV Security Code</label>
											</div>
											<div class="field-wraper">
												<div class="field_cover"> <input data-field-caption="CVV Security Code" data-fatreq="{&quot;required&quot;:true}" type="password" name="cc_cvv" value=""> </div>
											</div>
										</div>
									</div>
								</div>

							</form>


						</div>



					</section>
				</div>

				<div class="row align-items-center mt-4">
					<div class="col"><a class="btn btn--primary-border" onclick="setUpShippingMethod();" href="javascript:void(0)">Back</a></div>
					<div class="col-auto"><a class="btn btn--primary" onclick="setUpShippingMethod();" href="javascript:void(0)">Continue</a></div>

				</div>

			</div>
			<div class="col-lg-4 col-md-4">
				<div class="box box--white box--radius order-summary">
					<div class="p-4">
						<div class="section-head">
							<div class="section__heading">
								<h6>Shipping to:</h6>
							</div>
							<div class="section__action"><a href="#" class="btn btn--primary-border btn--sm">Change Address</a> </div>
						</div>
						<div class="shipping-address">
							Ablysoft: Kanwar<br>
							Plot no 268, JLPL industrial area<br>
							Mohali, Punjab<br>
							India 160055<br>
						</div>
					</div>
					<div class="divider"></div>
					<div class="p-4">
						<div class="section-head">
							<div class="section__heading">
								<h6>Your Order</h6>
							</div>
							<div class="section__action"><a href="#" class="btn btn--primary-border btn--sm">Edit cart</a> </div>
						</div>
						<div class="scrollbar-order-list" id="simplebar">
							<table class="cart-summary  table--justify order-table">
								<tbody>
									<tr class="physical_product_tab-js">
										<td>
											<div class="item__pic"><a href="/candle-ankle-formal-shoes-110"><img src="../image/product/44/EXTRA-SMALL/110/0/1" alt="Candle Ankle Formal Shoes" title="Candle Ankle Formal Shoes"></a></div>
										</td>
										<td>
											<div class="item__description">
												<div class="item__title"><a title="Candle Ankle Formal Shoes" href="/candle-ankle-formal-shoes-110">Candle Leather High Ankel Shoes Lace Up (Black)</a></div>
												<div class="item__specification">
													| Size: 7 | Quantity: 1 </div>
											</div>
										</td>
										<td>
											<div class="product_price"><span class="item__price"> $75.00 </span>
												<span class="text--normal text--normal-secondary">-6%</span>
											</div>
										</td>
									</tr>
									<tr class="physical_product_tab-js">
										<td>
											<div class="item__pic"><a href="/candle-ankle-formal-shoes-110"><img src="../image/product/44/EXTRA-SMALL/110/0/1" alt="Candle Ankle Formal Shoes" title="Candle Ankle Formal Shoes"></a></div>
										</td>
										<td>
											<div class="item__description">
												<div class="item__title"><a title="Candle Ankle Formal Shoes" href="/candle-ankle-formal-shoes-110">Candle Leather High Ankel Shoes Lace Up (Black)</a></div>
												<div class="item__specification">
													| Size: 7 | Quantity: 1 </div>
											</div>
										</td>
										<td>
											<div class="product_price"><span class="item__price"> $75.00 </span>
												<span class="text--normal text--normal-secondary">-6%</span>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="divider"></div>
					<div class="p-4">
						<div class="cartdetail__footer">
							<table>
								<tbody>
									<tr>
										<td class="text-left">Sub Total</td>
										<td class="text-right"> $75.00</td>
									</tr>
									<tr>
										<td class="text-left">Delivery Charges</td>
										<td class="text-right"> $11.00</td>
									</tr>
									<tr>
										<td class="text-left">Tax</td>
										<td class="text-right"> $5.63</td>
									</tr>

									<tr>
										<td class="text-left hightlighted">Net Payable</td>
										<td class="text-right hightlighted"> $91.63</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>