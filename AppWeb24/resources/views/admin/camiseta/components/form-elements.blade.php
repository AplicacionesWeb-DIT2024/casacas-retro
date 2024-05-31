<div class="form-group row align-items-center" :class="{'has-danger': errors.has('Nombre'), 'has-success': fields.Nombre && fields.Nombre.valid }">
    <label for="Nombre" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.camiseta.columns.Nombre') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.Nombre" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('Nombre'), 'form-control-success': fields.Nombre && fields.Nombre.valid}" id="Nombre" name="Nombre" placeholder="{{ trans('admin.camiseta.columns.Nombre') }}">
        <div v-if="errors.has('Nombre')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('Nombre') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('Descripción'), 'has-success': fields.Descripción && fields.Descripción.valid }">
    <label for="Descripción" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.camiseta.columns.Descripción') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.Descripción" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('Descripción'), 'form-control-success': fields.Descripción && fields.Descripción.valid}" id="Descripción" name="Descripción" placeholder="{{ trans('admin.camiseta.columns.Descripción') }}">
        <div v-if="errors.has('Descripción')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('Descripción') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('Precio'), 'has-success': fields.Precio && fields.Precio.valid }">
    <label for="Precio" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.camiseta.columns.Precio') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.Precio" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('Precio'), 'form-control-success': fields.Precio && fields.Precio.valid}" id="Precio" name="Precio" placeholder="{{ trans('admin.camiseta.columns.Precio') }}">
        <div v-if="errors.has('Precio')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('Precio') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('Talle'), 'has-success': fields.Talle && fields.Talle.valid }">
    <label for="Talle" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.camiseta.columns.Talle') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <select v-model="form.Talle" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('Talle'), 'form-control-success': fields.Talle && fields.Talle.valid}" id="Talle" name="Talle" placeholder="{{ trans('admin.camiseta.columns.Talle') }}">
            <option value="" disabled>{{ trans('admin.camiseta.columns.Talle') }}</option>
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

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('Cantidad'), 'has-success': fields.Cantidad && fields.Cantidad.valid }">
    <label for="Cantidad" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.camiseta.columns.Cantidad') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.Cantidad" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('Cantidad'), 'form-control-success': fields.Cantidad && fields.Cantidad.valid}" id="Cantidad" name="Cantidad" placeholder="{{ trans('admin.camiseta.columns.Cantidad') }}">
        <div v-if="errors.has('Cantidad')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('Cantidad') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('Categoría'), 'has-success': fields.Categoría && fields.Categoría.valid }">
    <label for="Categoría" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.camiseta.columns.Categoría') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.Categoría" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('Categoría'), 'form-control-success': fields.Categoría && fields.Categoría.valid}" id="Categoría" name="Categoría" placeholder="{{ trans('admin.camiseta.columns.Categoría') }}">
        <div v-if="errors.has('Categoría')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('Categoría') }}</div>
    </div>
</div>



