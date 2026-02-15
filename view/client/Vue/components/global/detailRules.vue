<template>
  <div id="accordion">
    <div class="card" v-for='(item,key) in data_rules.FareRules' :key='key'>
      <div class="card-header" id="headingOne">
        <h5 class="mb-0">
          <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            {{item.CityPair}}
          </button>
        </h5>
      </div>

      <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
        <div class="card-body">
          <div v-for='(item_detail,key_detail) in item.RuleDetails' :key='key_detail'>
            <div v-html="item_detail.Category"></div>
            <br/> ---------<br/>
            <div v-html="item_detail.Rules"></div>
            <hr/>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  name: 'detailRule',
  props:['data_rules']
}
</script>

<style scoped>

</style>