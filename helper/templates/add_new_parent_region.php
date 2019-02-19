<div class="new_add_parent_region_dialog" style="display: none;">
    <form class="form-horizontal" id="createParentRegion" name="createParentRegion" method="post" style="width: 100%">
        <div class="tab-content">
            <div class="tab-pane active" id="mail">
                <div class="accDiv tabDiv current" id="general">
                    <div class="formBox">
                        <input type="hidden" name="edit" id="hdnEdit" value="0" />
                        <ul class="row">
                            
                            <li class="">
                                <span for="NewRegionName" class="labelSpan star">Name:</span>
                                <div class="txtBox">
                                    <input type="text" name="NewRegionName" id="NewRegionName" class="txt required" title="Region Name" placeholder="Enter Region Name">
                                </div>
                            </li>
                            <li class="">
                                <span for="NewCode" class="labelSpan star">Code:</span>
                                <div class="txtBox">
                                    <input type="text" name="NewCode" id="NewCode" class="txt required" maxlength="50" title="Region Code" placeholder="Enter Region Code">
                                </div>

                            </li>
                            <li class="">
                                <span for="NewParentRegion" class="labelSpan">Parent Region:</span>
                                <div class="txtBox">
                                    <select name="NewParentRegion" id="NewParentRegion" title="Select Parent Region"> 
                                        <option value="">Root</option>
                                    </select> 
                                </div>
                            </li>
                            <li class="halfLi">
                                <span for="NewHelpDesk" class="labelSpan star">Help Desk Manager:</span>
                                <div class="txtBox">
                                    <select name="NewHelpDesk" id="NewHelpDesk" title="Select Help Desk Manager">
                                        <option value="">Select Help Desk Manager</option>
                                    </select>
                                </div>

                            </li>

                            <li class="halfLi">
                                <span for="NewEngineer" class="labelSpan">Engineer:</span>
                                <div class="txtBox">
                                    <select name="NewEngineer" id="NewEngineer" title="Select Engineer">
                                        <option value="">Select Engineer</option>
                                    </select>
                                </div>
                            </li>

                            <li class="halfLi">
                                <span for="sortOrder" class="labelSpan">Sort Order:</span>
                                <div class="txtBox">
                                    <input type="text" onkeypress="return isNumberic(event);"  maxlength="3" class="txt" id="sortOrder" name="sortOrder" title="Sort Order" placeholder="Enter Sort Order">
                                    <small>Maximum character length 3</small>
                                </div>

                            </li>
                            
                            <li class="halfLi">	
                                <span class="labelSpan">Status:</span>
                                <div class="optionBox">
                                    <div class="chkInn">
                                        <label>
                                            <input type="checkbox" class="checkbox">
                                            <input type="checkbox" class="checkbox" id="chkStatus" name="status" value="1" checked="checked" title="Category Status" data-content="Category Status">
                                            <span></span>
                                        </label>
                                        <label for="chkStatus" id="checkAct"></label>
                                    </div>                                                   
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>