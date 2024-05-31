<div class="form-group row align-items-center" :class="{'has-danger': errors.has('Talle'), 'has-success': fields.Talle && fields.Talle.valid }">
    <label for="Talle" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.talle.columns.Talle') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <select v-model="form.Talle" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('Talle'), 'form-control-success': fields.Talle && fields.Talle.valid}" id="Talle" name="Talle" placeholder="{{ trans('admin.talle.columns.Talle') }}">
            <option value="" disabled>{{ trans('admin.talle.columns.Talle') }}</option>
            <option value="S">S</option>
            <option value="M">M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
            <option value="XXL">XXL</option>
            <option value="XXXL">XXXL</option>
        </select>
        <div v-if="errors.has('Talle')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('Talle') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('Ancho'), 'has-success': fields.Ancho && fields.Ancho.valid }">
    <label for="Ancho" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.talle.columns.Ancho') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.Ancho" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('Ancho'), 'form-control-success': fields.Ancho && fields.Ancho.valid}" id="Ancho" name="Ancho" placeholder="{{ trans('admin.talle.columns.Ancho') }}">
        <div v-if="errors.has('Ancho')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('Ancho') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('Altura'), 'has-success': fields.Altura && fields.Altura.valid }">
    <label for="Altura" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.talle.columns.Altura') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.Altura" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('Altura'), 'form-control-success': fields.Altura && fields.Altura.valid}" id="Altura" name="Altura" placeholder="{{ trans('admin.talle.columns.Altura') }}">
        <div v-if="errors.has('Altura')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('Altura') }}</div>
    </div>
</div>


