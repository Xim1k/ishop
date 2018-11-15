<option value="" class="label"><?=$this->currency['code'];?></option>
<?foreach($this->currencies as $k => $v):?>
    <?if($k != $this->currency['code']):?>
        <option value="<?=$k;?>"><?=$k;?></option>
    <?endif;?>
<?endforeach;?>
