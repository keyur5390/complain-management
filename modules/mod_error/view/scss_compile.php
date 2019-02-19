<?php
	//restrict direct access to the page
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );	
        //print_r($data);
		$helperObj =$data['obj'];
		$files = $helperObj->loadFiles();
?>
<section>
    <div class="midTop">
        <div class="container-fluid">
            <div class="row">
                <div class="fullColumn">
                    <div class="topLeft">
                        <div class="pageTitle"><span>Compile SCSS File</span></div>
                    </div>
                    <div class="topRight btnRight">
                        <ul class="btnUl">
                            <li><a title="Compile" class="trans comBtn" id="btnCompile" href="#">Compile</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>            	
    </div>
    <div class="middlePart">
        <div class="container-fluid">
            <div class="row">
                <div class="fullColumn">
                    <div class="midWhite">
                        <div class="tabBox">
                             <div class="formBox">
                                        <form id="frmSCSS" class="form-horizontal" method="post" >
                                            <ul class="row">
                                                <li>
                                                    <span class="labelSpan star" for="txtTitle">Select File:</span>
                                                    <div class="txtBox">
                                                        <select id="cmbFile" title="Select File" name="cmbFile">
                                                            <option value="">Select File</option>
															<?php  
															foreach($files as $file) {
															?>
															<option value="<?php echo $file; ?>" <?php echo ($_POST['cmbFile']==$file)?"selected":""; ?>><?php echo $file; ?></option>
															<?php			
															}
															
															?>
                                                        </select>
                                                    </div>
                                                </li>
                                            </ul>
                                        </form>
                                    </div>
							
						
                        </div>
                    </div>
                </div>    
            </div>
			
			<div class="row">
				<div class="fullColumn">
					<div class="midWhite">
						<div class="tabBox">
							<div class="formBox">
							<?php if(count($data['errors'])!=0) { ?>
								<span class="labelSpan" for="txtTitle">Errors:</span><br />
							   <ul>
							   <?php $err=$data['errors']; 
								foreach($err as $e){
								?>	
									<li class="redColor"><?php echo $e; ?></li>
								<?php	
								}
							   ?>
							   </ul>
							<?php } else if(isset($data['errors']) && count($data['errors'])==0) { ?>
								<span class="labelSpan greenColor">No Errors</span>
							<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
					
        </div>    
    </div>
</section>