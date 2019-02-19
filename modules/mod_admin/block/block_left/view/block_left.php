<?php 
	//restrict direct access to the page
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );
	 
?>
<!--Responsive navigation button-->  
                <div class="resBtn">
                    <a href="#" style="padding: 9px;"><span class="icon12 icomoon-icon-arrow-down-2" style="font-size: 24px; margin: 0;"></span></a>
                </div>
                
                <!--Left Sidebar collapse button-->  
                <div class="collapseBtn leftbar">
                     <a href="#" class="tipR" title="Hide Left Sidebar">
<!--                         <span class="icon12 minia-icon-layout"></span>-->
                         <span class="icon12 icomoon-icon-arrow-left-2" style="font-size: 18px;"></span>
                     </a>
                </div>
        
                <!--Sidebar background-->
                <div id="sidebarbg"></div>
                <!--Sidebar content-->
                <div id="sidebar">
        
                    <div class="shortcuts">
                        <ul>                            
                            <li><a href="<?php echo CFG::$livePath ?>" target="_blank" title="View Live Site" class="tip"><span class="icon24 icomoon-icon-tv-2"></span></a></li>
                            <li><a href="index.php?m=mod_seo&a=seo_list" title="SEO Manager" class="tip"><span class="icon24 icomoon-icon-stats-up"></span></a></li>
                            <li><a href="index.php?m=mod_config&a=site_config" title="Site Config" class="tip"><span class="icon24 icomoon-icon-cog"></span></a></li>     
                            <li><a href="index.php?m=mod_user&a=update_profile" title="Edit Profile" class="tip"><span class="icon24 icomoon-icon-user"></span></a></li>                      
                        </ul>
                    </div><!-- End search -->            
        
                    <div class="sidenav">
        
                        <div class="sidebar-widget" style="margin: -1px 0 0 0;">
                            <h5 class="title" style="margin-bottom:0">Navigation</h5>
                        </div><!-- End .sidenav-widget -->
        
                        <div class="mainnav">
                            <ul>
								<?php 
									$oldMenu = "";
									foreach($data as $key => $val)
									{
										if($oldMenu != $val['module_key'])
										{
											if($oldMenu != "")
												echo "</ul></li>";
												
											$oldMenu = $val['module_key'];
											
											$iconClass = "icomoon-icon-list-view-2"; // default class
											
											if(trim($val['icon_class']) != "")		// custom class
												$iconClass = $val['icon_class'];
												
											
											echo '<li>
                                    				<a href="#"><span class="icon16 '.$iconClass.'"></span>'.$val['moduleName'].'<span class="notification green">10</span></a>
													<ul class="sub '.((APP::$moduleName==$val['module_key'])?"expand":"").'">';
										}
										$class='';
										$relArray=explode(",",$val['related_actions']);
										
										if(APP::$actionName==$val['action']) {
										  $class='class="current"';	
										}
										else if(in_array(APP::$actionName,$relArray)==true) {
										  $class='class="current"';	
										}
										//echo '<li><a '.((APP::$actionName==$val['action'])?'class="current"':'').' href="index.php?m='.$val['module_key'].'&a='.$val['action'].'"><span class="icon16 icomoon-icon-arrow-right-2"></span>'.$val['admin_menu_label'].'</a></li>';
										echo '<li><a '.$class.' href="index.php?m='.$val['module_key'].'&a='.$val['action'].'"><span class="icon16 icomoon-icon-arrow-right-2"></span>'.$val['admin_menu_label'].'</a></li>';										
										
										if($key == (count($data)-1))
										{
											echo '</ul>
													</li>';
										}
										
									}
								?>
                                <!--<li><a href="charts.html"><span class="icon16 icomoon-icon-stats-up"></span>Charts</a></li>
                                <li>
                                    <a href="#"><span class="icon16 icomoon-icon-list-view-2"></span>Forms</a>
                                    <ul class="sub">
                                        <li><a href="forms.html"><span class="icon16 icomoon-icon-file"></span>Forms Stuff</a></li>
                                        <li><a href="forms-validation.html"><span class="icon16 icomoon-icon-file"></span>Validation</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#"><span class="icon16 icomoon-icon-grid"></span>Tables</a>
                                    <ul class="sub">
                                        <li><a href="tables.html"><span class="icon16 icomoon-icon-arrow-right-2"></span>Static</a></li>
                                        <li><a href="data-table.html"><span class="icon16 icomoon-icon-arrow-right-2"></span>Data table</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#"><span class="icon16 icomoon-icon-equalizer-2"></span>UI Elements</a>
                                    <ul class="sub">
                                        <li><a href="icons.html"><span class="icon16 icomoon-icon-rocket"></span>Icons</a></li>
                                        <li><a href="buttons.html"><span class="icon16 icomoon-icon-file"></span>Buttons</a></li>
                                        <li><a href="elements.html"><span class="icon16 icomoon-icon-cogs"></span>Elements</a></li>
                                    </ul>
                                </li>
                                <li><a href="typo.html"><span class="icon16 icomoon-icon-font"></span>Typography</a></li>
                                <li><a href="grid.html"><span class="icon16 icomoon-icon-grid-view"></span>Grid</a></li>
                                <li><a href="calendar.html"><span class="icon16 icomoon-icon-calendar"></span>Calendar</a></li>
                                <li>
                                    <a href="widgets.html"><span class="icon16 icomoon-icon-cube"></span>Widgets<span class="notification green">32</span></a>
                                </li>
                                <li><a href="file.html"><span class="icon16 icomoon-icon-upload"></span>File Manager</a></li>
                                <li>
                                    <a href="#"><span class="icon16 icomoon-icon-file"></span>Error pages<span class="notification">6</span></a>
                                    <ul class="sub">
                                        <li><a href="403.html"><span class="icon16 icomoon-icon-file"></span>Error 403</a></li>
                                        <li><a href="404.html"><span class="icon16 icomoon-icon-file"></span>Error 404</a></li>
                                        <li><a href="405.html"><span class="icon16 icomoon-icon-file"></span>Error 405</a></li>
                                        <li><a href="500.html"><span class="icon16 icomoon-icon-file"></span>Error 500</a></li>
                                        <li><a href="503.html"><span class="icon16 icomoon-icon-file"></span>Error 503</a></li>
                                        <li><a href="offline.html"><span class="icon16 icomoon-icon-file"></span>Offline page</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#"><span class="icon16 icomoon-icon-box"></span>Other pages<span class="notification blue">10</span></a>
                                    <ul class="sub">
                                        <li><a href="invoice.html"><span class="icon16 icomoon-icon-file"></span>Invoice page</a></li>
                                        <li><a href="profile.html"><span class="icon16 icomoon-icon-file"></span>User profile</a></li>
                                        <li><a href="search.html"><span class="icon16 icomoon-icon-search-3"></span>Search page</a></li>
                                        <li><a href="email.html"><span class="icon16 icomoon-icon-mail-3"></span>Email page</a></li>
                                        <li><a href="support.html"><span class="icon16  icomoon-icon-support"></span>Support page</a></li>
                                        <li><a href="faq.html"><span class="icon16 icomoon-icon-flag-3"></span>FAQ page</a></li>
                                        <li><a href="structure.html"><span class="icon16 icomoon-icon-file"></span>Blank page</a></li>
                                        <li><a href="fixed-topbar.html"><span class="icon16 icomoon-icon-file"></span>Fixed topbar</a></li>
                                        <li><a href="right-sidebar.html"><span class="icon16 icomoon-icon-file"></span>Right sidebar</a></li>
                                        <li><a href="two-sidebars.html"><span class="icon16 icomoon-icon-file"></span>Two sidebars</a></li>
                                    </ul>
                                </li>-->
                            </ul>
                        </div>
                    </div><!-- End sidenav -->
        
                </div><!-- End #sidebar -->