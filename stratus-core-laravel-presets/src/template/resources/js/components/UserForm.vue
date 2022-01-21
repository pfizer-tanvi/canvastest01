<template>
  <div>
    <b-container fluid>
      <b-col md="8" class="my-1">
      <b-form :action="targetRoute" method='POST'>
        <input name="_method" type="hidden" :value="targetMethod">
        <input type="hidden" name="_token" :value="csrf">
        <b-form-group>
          <b-row>
            <label class="mr-sm-2">Name</label>
            <b-form-input id="name" name="name" v-model.trim="userObject.name"/>
          </b-row>

          <b-row>
            <label class="mr-sm-2">Email</label>
            <b-form-input id="email" name="email" v-model.trim="userObject.email"/>
          </b-row>

          <b-row>
            <b-form-checkbox
              id="is_super_admin"
              value="1"
              unchecked-value="0"
              v-model="userObject.is_super_admin"
              name="is_super_admin"
            >Super Admin</b-form-checkbox>
          </b-row>

          <br>

          <b-row>
            <b-button type="submit" variant="primary">Submit</b-button>
          </b-row>
        </b-form-group>
      </b-form>
      </b-col>
    </b-container>
  </div>
</template>

<script>
export default {
  props: ['route', 'method', 'user', 'csrf'],
  data() {
    return {
      userObject : JSON.parse(this.user),
      targetRoute : this.route,
      targetMethod : this.method,
    };
  },
};
</script>

