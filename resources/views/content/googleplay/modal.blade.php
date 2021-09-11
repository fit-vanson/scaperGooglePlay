
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content panel-warning">
            <div class="modal-header panel-heading">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row input_note">
                    <div class="card-body">
                        <form class="form change_note" id="change_note">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="hidden" name="id" id="id">
                                        <label for="first-name-vertical">Ghi chú</label>
                                        <textarea type="text" rows="5" id="note" class="form-control" name="note"> </textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mr-1 waves-effect waves-float waves-light">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="swiper-responsive-breakpoints swiper-container input_screenshot_img">
                    <div class="swiper-wrapper" id="screenshot_img">
                        <div class="swiper-slide">
                        </div>
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="modal_link" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content panel-warning">
            <div class="modal-header panel-heading">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-2">
                        <span> Icon:</span>
                    </div>
                    <div class="col-xl-8">
                        <div class="form-group">
                            <input type="text" class="form-control" id="copy-icon-input" value="Icon" />
                        </div>
                    </div>
                    <div class="col-xl-2">
                        <button class="btn btn-outline-primary" id="btn-copy-icon">Copy!</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-2">
                        <span> Banner:</span>
                    </div>
                    <div class="col-xl-8">
                        <div class="form-group">
                            <input type="text" class="form-control" id="copy-banner-input" value="Banner" />
                        </div>
                    </div>
                    <div class="col-xl-2">
                        <button class="btn btn-outline-primary" id="btn-copy-banner">Copy!</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-2">
                        <span> Preview: </span>
                    </div>
                    <div class="col-xl-8">
                        <div class="form-group">
                            <textarea rows="20" type="text" class="form-control" id="copy-preview-input"> </textarea>
                        </div>
                    </div>
                    <div class="col-xl-2">
                        <button class="btn btn-outline-primary" id="btn-copy-preview">Copy!</button>
                    </div>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->