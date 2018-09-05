<div class="mui-content">
    <form id="form" action="" enctype="multipart/form-data" method="post">
        <div class="appraise-head">
            <img id="product_img" src="" alt="">
            <div class="appraise-point">
                <text>商品评分</text>
                <i class="mui-icon"></i><i class="mui-icon"></i><i class="mui-icon"></i><i class="mui-icon"></i><i class="mui-icon"></i>
                <input type="hidden" name="grade">
            </div>
        </div>
        <div class="appraise-text">
            <textarea name="evaluate" placeholder="宝贝满足您的期待吗？说说您的使用心理，分享给想买的他们吧"></textarea>
        </div>
        <div class="appraise-image">
            <div class="appraise-image-title">添加图片(最多10个)</div>
            <div class="appraise-image-content">
                <i class="mui-icon mui-icon-image uploadImg"><em>+</em></i>
                <input type="file" name="image[]" class="uploadAction" accept="image/*">
            </div>
        </div>
        <div class="appraise-submit">提交</div>
    </form>
</div>