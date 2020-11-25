<!-- Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="addProductModalLabel">新增商品</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="btn btn-info">
                            <input id="upload" style="display:none;" type="file" multiple>
                            <i class="fas fa-upload"></i> 上傳圖片
                        </label>
                    </div>
                    <div class="form-group clearfix" id="productsImage">
                    </div>
                    <div class="form-group">
                        <label for="name">商品名稱</label>
                        <input type="text" class="form-control" id="name" aria-describedby="nameHelp"
                            placeholder="輸入商品名稱">
                    </div>
                    <div class="form-group">
                        <label for="description">商品介紹:</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">商品價格</label>
                        <input type="text" class="form-control" id="price" aria-describedby="priceHelp"
                            placeholder="輸入商品價格">
                    </div>
                    <div class="form-group">
                        <label for="price">商品庫存</label>
                        <input type="text" class="form-control" id="inventory" aria-describedby="priceHelp"
                            placeholder="輸入商品庫存">
                    </div>
                    <div class="form-group">
                        <label for="type">狀態:</label>
                        <select class="form-control" name="type" id="type">
                            <option value="1" selected>
                                上架中
                            </option>
                            <option value="0">
                                下架中
                            </option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success">儲存</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                </div>
            </form>
        </div>
    </div>
</div>
