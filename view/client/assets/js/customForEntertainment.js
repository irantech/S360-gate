function RemoveDataTable(thiss) {
  if (
    thiss
      .parent()
      .parent()
      .parent()
      .parent()
      .find('div[data-target="BaseDataTableDiv"]').length > 1
  ) {
    thiss.parent().parent().parent().remove()

    var CountDivInEach = 0
    $('.DynamicDataTable input[data-parent="DataTableValues"]').each(
      function () {
        $(this).attr(
          "name",
          "DataTable[" +
          CountDivInEach +
          "][" +
          $(this).attr("data-target") +
          "]"
        )
        if ($(this).attr("data-target") == "body") {
          CountDivInEach = CountDivInEach + 1
        }
      }
    )
  }
}

function AddDataTable() {
  var CountDiv = $('div[data-target="BaseDataTableDiv"]').length
  var BaseDiv = $('div[data-target="BaseDataTableDiv"]:last-child')
  var CloneBaseDiv = $('div[data-target="BaseDataTableDiv"]:last-child').clone()
  var CountDivInEach = 0

  CloneBaseDiv.find("input").val("")
  $('div[data-target="BaseDataTableDiv"]:last-child').after(CloneBaseDiv)

  $('.DynamicDataTable input[data-parent="DataTableValues"]').each(function () {
    $(this).attr(
      "name",
      "DataTable[" + CountDivInEach + "][" + $(this).attr("data-target") + "]"
    )
    if ($(this).attr("data-target") == "body") {
      CountDivInEach = CountDivInEach + 1
    }
  })
}

function showEntertainmentTab(parent_id) {
  $("#myTabContent")
    .find('[role="tabpanel"]')
    .each(function () {
      $(this).removeClass("active show")
    })
  $("#category-tab-" + parent_id).tab("show")
}

window.onpopstate = function (event) {
  const url = new URL(window.location)
  var parent_id = 0
  if (url.searchParams.has("parent_id")) {
    parent_id = url.searchParams.get("parent_id")
  }
  getCategoryData($("#entertainment_category_list"), parent_id, false)

  showEntertainmentTab(parent_id)
}

function refreshData(targetTable) {
  targetTable.DataTable().clear().destroy()
  targetTable.children("tr").remove()
  targetTable.children("tbody").remove()
  targetTable.children("thead").remove()
}

function refreshAllEntertainment() {
  getCategoryData($("#entertainment_category_list"))
}

function createNewEntertainmentCategoryModal(thiss, parent_id = "0") {

  loadingBtn(thiss)
  $.ajax({
    type: "POST",
    url: amadeusPath + "entertainment_ajax.php",
    data: {
      flag: "categoryList",
      parent_id: parent_id,
    },
    success: function (response) {
      var categories = JSON.parse(response)
      var categoriesArray =
        '<option value="' + parent_id + '">' + useXmltag("Leader") + "</option>"
      if (parent_id === "0") {
        $.each(categories, function (index, value) {
          categoriesArray +=
            '<option value="' +
            value.CategoryId +
            '">' +
            value.CategoryTitle +
            "</option>"
        })
      }
      $(thiss.data("target")).modal("show")
      var modalBody = $(thiss.data("target")).find(".modal-body")
      var modalHeader= $(thiss.data('target')).find('.modal-header').find('h5');
      var newHtml = ""
      newHtml =
        '<div class="col-md-12 d-flex flex-wrap">' +
        '<form class="w-100 d-flex flex-wrap" method="post" id="formSubmitNewEntertainmentCategory" action="' +
        amadeusPath +
        "entertainment_ajax.php" +
        '"> '
      newHtml += inputLoop("", "flag", "newEntertainmentCategory", true)
      newHtml += inputLoop(
        useXmltag("Title"),
        "EntertainmentCategoryTitle",
        "",
        false,
        {
          size: "col-md-12",
        }
      )
      newHtml +=
        '<div class="col-md-6 d-none mb-4">\n' +
        '<label for="RadioParent" class="control-label float-right mb-2">' +
        useXmltag("InsertIn") +
        "</label>" +
        '<select name="RadioParent" id="RadioParent" class="form-control">\n' +
        categoriesArray +
        "</select>" +
        "</div>"
      newHtml += inputLoop("", "FormStatus", "new", true)

      newHtml += "</form></div>"

      modalBody.html(newHtml)
      modalHeader.html(useXmltag("NewCategory"));
      $(thiss.data("target"))
        .find('button[data-type="submit"]')
        .removeClass("d-none")
        .attr("onClick", "submitNewEntertainmentCategory($(this))")
        .attr("data-target", "#exampleModal")
        .attr("data-parent-id", parent_id)

      loadingBtn(thiss, false)
    },
  })
}

function getSelectBoxCities(country_id,city_id=null) {
  var citiesArray = ""
  $.ajax({
    type: "POST",
    url: amadeusPath + "entertainment_ajax.php",
    data: {
      flag: "getEntertainmentCities",
      filter: "false",
      country_id: country_id,
    },
    success: function (response) {
      var cities = JSON.parse(response)
      citiesArray +="<option value='all'>" + useXmltag("All") + "</option>";
      $.each(cities, function (index, value) {
        citiesArray +=
          "<option " +
          (value.id === city_id ? "selected" : "") +
          ' value="' +
          value.id +
          '">' +
          value.name +
          "</option>"
      })

      $('#EntertainmentCityTitle').html(citiesArray)

    }
  })
}

function createNewEntertainmentModal(thiss, category_id, parent_id, check_offline,check_online) {

  loadingBtn(thiss)
  $.ajax({
    type: "POST",
    url: amadeusPath + "entertainment_ajax.php",
    data: {
      flag: "categoryList",
      parent_id: parent_id,
      check_offline: check_offline,
      check_online: check_online,
    },
    success: function (response) {
      $.ajax({
        type: "POST",
        url: amadeusPath + "entertainment_ajax.php",
        data: {
          flag: "getEntertainmentTypes",
        },

        success: function (typeResponse) {
          $.ajax({
            type: "POST",
            url: amadeusPath + "entertainment_ajax.php",
            data: {
              flag: "getEntertainmentCountries",
              filter: "false",
            },

            success: function (countryResponse) {
              $.ajax({
                type: "POST",
                url: amadeusPath + "entertainment_ajax.php",
                data: {
                  flag: "getEntertainmentCurrency",
                  filter: "false",

                },
            success: function (currencyResponse) {

              var categories = JSON.parse(response)
              var countries = JSON.parse(countryResponse)
              var currency = JSON.parse(currencyResponse)

              var countriesArray = ""
              var categoriesArray = ""
              var currencyArray = ""

              $.each(categories, function (index, value) {
                categoriesArray +=
                  "<option " +
                  (value.CategoryId === category_id ? "selected" : "") +
                  ' value="' +
                  value.CategoryId +
                  '">' +
                  value.CategoryTitle +
                  "</option>"
              })

              $.each(countries, function (index, value) {
                console.log(value)
                console.log(lang)
                var country_name = lang == 'fa' ? value.name : value.name_en
                countriesArray +=
                  "<option " +
                  ' value="' +
                  value.id +
                  '">' + country_name +
                  "</option>"
              })
              $.each(currency, function (index,  value) {
                console.log(value)
                console.log(lang)
                var currency_names = lang == 'fa' ? value.CurrencyTitle : value.CurrencyTitleEn
                currencyArray +=
                  "<option " +
                  ' value="' +
                  value.CurrencyCode +
                  '">' + currency_names +
                  "</option>"
              })



              $(thiss.data("target")).modal("show")
              var modalBody = $(thiss.data("target")).find(".modal-body")
              var modalHeader= $(thiss.data('target')).find('.modal-header').find('h5');

              var newHtml = ""
              newHtml =
                '<div class="col-md-12 d-flex flex-wrap">' +
                '<form class="w-100 d-flex flex-wrap" enctype="multipart/form-data" method="post" id="formSubmitNewEntertainment" action="' +
                amadeusPath +
                "entertainment_ajax.php" +
                '"> '
              newHtml += inputLoop("", "flag", "AddEntertainment", true)
              newHtml += inputLoop("", "category_id", category_id, true)
              newHtml += inputLoop("", "pageType", 'client', true)
              // newHtml += inputLoop("", "isRequest1", check_offline, check_offline)
              // newHtml += inputLoop("", "is_request2", check_online, check_online)
              if (check_offline ==1  && check_online == 1) {
                newHtml +=
                  '<div class="col-md-8  mb-6">\n' +
                  '<input class="form-check-input" type="radio" name="is_request" id="isRequest1" checked value="false">' +
                  '<label  class="form-check-label mx-3" >' +
                  useXmltag("S360Entertainment") + ' ' + useXmltag("online") +
                  '</label>' +
                  '<input class="form-check-input" type="radio" name="is_request" id="isRequest2"  value="true">' +
                  '<label  class="form-check-label mx-3" >' +
                  useXmltag("S360Entertainment") + ' ' + useXmltag("offline") +
                  '</label>' +
                  "</div>"
              }else if (check_offline ==1 ) {
                newHtml +=
                  "<input  type=\"hidden\" name=\"is_request\" id=\"isRequest1\" checked value=\"true\">"
              }else {
                newHtml +=
                  "<input  type=\"hidden\" name=\"is_request\" id=\"isRequest1\" checked value=\"false\">"
              }
              newHtml += inputLoop(useXmltag("Title"), "title", "", false, {
                size: "col-md-6",
              })
              // newHtml += inputLoop(useXmltag("TitleEnglish"), "title_en", "", false, {
              //   size: "col-md-6",
              // })
              newHtml +=
                 '<div class="col-md-6 d-flex flex-wrap mb-4">\n' +
                 '<label for="title_en" class="control-label mb-2">'+ useXmltag("TitleEnglish") +'</label>\n' +
                 '<input type="text" class="form-control"\n' +
                 'value=""\n' +
                 'data-id="title_en"\n' +
                 'id="title_en" name="title_en[]"\n' +
                 'placeholder="'+ useXmltag("TitleEnglish") +'">\n' +
                 '</div>'
              newHtml += inputLoop(useXmltag("Price"), "price", "", false, {
                size: "col-md-4",
              })
              // newHtml += inputLoop(useXmltag("ArziPrice"), "currency_price", "", false, {
              //   size: "col-md-4",
              // })
              newHtml +=
                 '<div class="col-md-4 d-flex flex-wrap mb-4">\n' +
                 '<label for="currency_price" class="control-label mb-2">'+ useXmltag("ArziPrice") +'</label>\n' +
                 '<input type="text" class="form-control"\n' +
                 'value=""\n' +
                 'data-id="currency_price"\n' +
                 'id="currency_price" name="currency_price[]"\n' +
                 'placeholder="'+ useXmltag("ArziPrice") +'">\n' +
                 '</div>'
              newHtml +=
                '<div class="col-md-4  mb-4">\n' +
                '<label for="EntertainmentCategoryTitle" class="control-label float-right mb-2">' +
                useXmltag("Typecurrency") +
                "</label>" +
                '<select name="currency_type" id="currency_type" class="form-control">\n' +
                '<option value="">انتخاب کنید....</option>\n' +
                currencyArray +
                "</select>" +
                "</div>"
              // newHtml += inputLoop(useXmltag("Discount"), "discount_price", "", false, {
              //   size: "col-md-4",
              // })
              newHtml +=
                 '<div class="col-md-4 d-flex flex-wrap mb-4">\n' +
                 '<label for="discount_price" class="control-label mb-2">'+ useXmltag("Discount") +'</label>\n' +
                 '<input type="text" class="form-control"\n' +
                 'value=""\n' +
                 'data-id="discount_price"\n' +
                 'id="discount_price" name="discount_price[]"\n' +
                 'placeholder="'+ useXmltag("Discount") +'">\n' +
                 '</div>'
              newHtml +=
                '<div class="col-md-4  mb-4">\n' +
                '<label for="EntertainmentCategoryTitle" class="control-label float-right mb-2">' +
                useXmltag("InsertIn") +
                "</label>" +
                '<select name="RadioParent" id="RadioParent" class="form-control">\n' +
                categoriesArray +
                "</select>" +
                "</div>"

              newHtml +=
                '<div class="col-md-4  mb-4">\n' +
                '<label for="EntertainmentCountryTitle" class="control-label float-right mb-2">' +
                useXmltag("Country") +
                "</label>" +
                '<select required onchange="getSelectBoxCities($(this).val())" name="EntertainmentCountryTitle[]" id="EntertainmentCountryTitle" class="form-control">\n' +
                '<option selected value="">' + useXmltag("ChoseOption") + '</option>\n' +

                countriesArray +
                "</select>" +
                "</div>"


              newHtml +=
                '<div class="col-md-4  mb-4">\n' +
                '<label for="EntertainmentCityTitle" class="control-label float-right mb-2">' +
                useXmltag("City") +
                "</label>" +
                '<select required onchange="" name="EntertainmentCityTitle[]" id="EntertainmentCityTitle" class="form-control">\n' +
                '<option disabled selected value="0">' + useXmltag("ChoseOption") + '</option>\n' +

                "</select>" +
                "</div>"


              var types = JSON.parse(typeResponse)

              var typeArray = ""
              $.each(types, function (index, value) {
                typeArray +=
                  '<option value="' +
                  value.id +
                  '">' +
                  value.title +
                  "</option>"
              })

              newHtml +=
                '<div class="col-md-4  mb-4">\n' +
                '<label for="EntertainmentTypes" class="control-label float-right mb-2">' +
                useXmltag("Options") +
                "</label>" +
                '<select name="EntertainmentTypes[]" multiple="multiple" id="EntertainmentTypes" class="form-control Select2Tag">\n' +
                typeArray +
                "</select>" +
                "</div>"

              newHtml +=
                '<div class="form-group d-flex flex-wrap col-sm-12 DynamicDataTable">\n' +
                '    <span class="control-label float-right mb-2 col-md-12 p-0">' +
                useXmltag("IntroducingServices") +
                "</span>\n" +
                '    <div data-target="BaseDataTableDiv" class="col-sm-12 d-flex flex-wrap p-0 form-group">\n' +
                '        <div class="col-md-3 pr-0">\n' +
                '            <input data-parent="DataTableValues" data-target="title" name="DataTable[0][title]" placeholder="' +
                useXmltag("Title") +
                '" class="form-control"\n' +
                '                  type="text">\n' +
                "        </div>\n" +
                '        <div class="col-md-7">\n' +
                '            <input data-parent="DataTableValues" data-target="body" name="DataTable[0][body]" placeholder="' +
                useXmltag("Description") +
                '" class="form-control"\n' +
                '                  type="text">\n' +
                "        </div>\n" +
                '        <div class="col-md-2 d-flex flex-wrap p-0">\n' +
                '            <div class="col-md-6 p-0">\n' +
                '                <button type="button" onclick="AddDataTable()" class="btn form-control btn-success">\n' +
                '                    <span class="fa fa-plus"></span>\n' +
                "                </button>\n" +
                "            </div>\n" +
                '            <div class="col-md-6 p-0">\n' +
                '                <button onclick="RemoveDataTable($(this))" type="button" class="btn form-control btn-danger">\n' +
                '                    <span class="fa fa-remove"></span>\n' +
                "                </button>\n" +
                "            </div>\n" +
                "        </div>\n" +
                "    </div>\n" +
                "</div>"


              newHtml += `
              <div class="richtext-field">
                  <label class="richtext-label">
                      ${useXmltag("Description")}
                  </label>
              
                  <textarea
                      id="description"
                      name="description[]"
                      class="ckeditor"
                      dir="rtl"
                      rows="6">
                  </textarea>
              </div>
              `;




              newHtml +=
                '<div class="form-group col-sm-12">\n' +
                '    <label for="video" class="control-label float-right">' +
                useXmltag("Video") +
                "</label>\n" +
                '    <textarea id="video" name="video[]" class="form-control"></textarea>\n' +
                "</div>"

              newHtml +=
                '<div class="form-group col-lg-6 col-md-6 col-xs-6 col-sm-6">\n' +
                '    <label for="picEntertainment" class="control-label float-right">' +
                useXmltag("Indeximg") +
                "</label>\n" +
                '    <input type="file" name="picEntertainment" id="picEntertainment" class="dropify" data-height="100">\n' +
                "</div>"

              newHtml +=
                '<div class="form-group col-lg-6 col-md-6 col-xs-6 col-sm-6">\n' +
                '    <label for="package" class="control-label float-right">' +
                useXmltag("Packageselection") +
                "</label>\n" +
                '    <input type="file" name="package" id="package" class="dropify" data-height="100">\n' +
                "</div>"

              newHtml += "</form></div>"

              modalBody.html(newHtml)
              if (typeof CKEDITOR !== 'undefined') {
                CKEDITOR.replace('description', {
                });
              }

              modalHeader.html(useXmltag("NewEntertainment"));
              $(".Select2Tag").select2()
              $(thiss.data("target"))
                .find('button[data-type="submit"]')
                .removeClass("d-none")
                .attr("onClick", "submitNewEntertainment($(this))")
                .attr("data-target", "#exampleModal")
                .attr("data-category-id", category_id)
                .attr("data-parent-id", parent_id)

              loadingBtn(thiss, false)
            },

          })
        },
          })
        },
        error: function (e) {
          // error callback
          console.log(e)
          alert("insert one type")
        },
      })
    },
  })
}

function getEntertainmentCategories(thiss) {
  var myTabContent = $("#myTabContent")
  $.ajax({
    type: "post",
    url: amadeusPath + "entertainment_ajax.php",
    data: {
      flag: "categoryList",
      parent_id: "0",
      member_only: "1",
    },
    success: function (data) {
      var JsonData = JSON.parse(data)

      thiss.find("li:not(.stable-tab)").remove()
      thiss.find("div:not(.stable-tab)").remove()

      $.each(JsonData, function (i, item) {
        thiss.append(
          '<li class="nav-item">\n' +
          '            <a class="nav-link" id="category-tab-' +
          item.CategoryId +
          '"' +
          " onclick=\"getCategoryData($('#entertainment_category_list'),'" +
          item.CategoryId +
          '\')" data-toggle="tab" href="#category-div-' +
          item.CategoryId +
          '" role="tab" aria-controls="category-div-' +
          item.CategoryId +
          '" aria-selected="true">\n' +
          item.CategoryTitle +
          "            </a>\n" +
          "        </li>"
        )

        myTabContent.append(
          "" +
          '<div class="tab-pane fade" id="category-div-' +
          item.CategoryId +
          '" role="tabpanel" aria-labelledby="category-tab-' +
          item.CategoryId +
          '">' +
          '            <div class="col-md-12 bg-white pt-3">\n' +
          '                <button class="btn site-bg-main-color" type="button" data-target="#exampleModal"\n' +
          "                        onclick=\"createNewEntertainmentCategoryModal($(this),'" +
          item.CategoryId +
          "')\">\n" +
          "" +
          useXmltag("NewSubCategory") +
          " \n" +
          "                </button>\n" +
          "            </div>" +
          " </div>"
        )
      })
      const searchParams = new URLSearchParams(window.location.search)
      if (searchParams.has("parent_id")) {
        showEntertainmentTab(searchParams.get("parent_id"))
      }
    },
  })
}

function submitNewEntertainmentCategory(thiss) {
  loadingBtn(thiss)
  var FilterData = $("#formSubmitNewEntertainmentCategory").serialize()
  const searchParams = new URLSearchParams(window.location.search)
  let parent_id = "0"
  if (searchParams.has("parent_id")) {
    parent_id = searchParams.get("parent_id")
  }
  $.ajax({
    type: "post",
    url: amadeusPath + "entertainment_ajax.php",
    data: {
      flag: "newEntertainmentCategory",
      Param: FilterData,
    },
    success: function (data) {
      var JsonData = JSON.parse(data)
      $(thiss.data("target")).modal("hide")
      loadingBtn(thiss, false)
      getCategoryData($("#entertainment_category_list"), parent_id, true)
      showEntertainmentTab(JsonData.lastId)

      $("#myTabContent")
        .find('[role="tabpanel"]')
        .each(function () {
          $(this).removeClass("active show")
        })
      $("#all-categories-tab").tab("show")
      $("#all-categories").addClass("active show")
    },
  })
}

function submitNewEntertainment(thiss) {

  // var FilterData =  new FormData($('#formSubmitNewEntertainment'));
  let form2 = $("#formSubmitNewEntertainment")
  if (!form2.validate().form()) return false;
  loadingBtn(thiss)
  // you can't pass Jquery form it has to be javascript form object
  // var FilterData = new FormData(form[0]);

  // console.log(FilterData);
  const searchParams = new URLSearchParams(window.location.search)
  let parent_id = "0"
  if (searchParams.has("parent_id")) {
    parent_id = searchParams.get("parent_id")
  }
  form2.ajaxSubmit({
    type: "post",
    url: amadeusPath + "entertainment_ajax.php",
    enctype: "multipart/form-data",
    processData: false,
    contentType: false,
    data: {
      flag: "AddEntertainment",
    },
    success: function (data) {
      var JsonData = JSON.parse(data)
      console.log(JsonData)
      $(thiss.data("target")).modal("hide")
      loadingBtn(thiss, false)

      getEntertainmentDataV2(
        $("#entertainment_category_list"),
        thiss.data("category-id"),
        thiss.data("parent-id")
      )
    },
  })
}

function editEntertainmentCategory(thiss) {
  loadingBtn(thiss)
  var FilterData = $("#formSubmitEditEntertainmentCategory").serialize()
  const searchParams = new URLSearchParams(window.location.search)
  let parent_id = "0"
  if (searchParams.has("parent_id")) {
    parent_id = searchParams.get("parent_id")
  }
  $.ajax({
    type: "post",
    url: amadeusPath + "entertainment_ajax.php",
    data: {
      flag: "editEntertainmentCategory",
      Param: FilterData,
    },
    success: function (data) {
      var JsonData = JSON.parse(data)
      $(thiss.data("target")).modal("hide")
      loadingBtn(thiss, false)
      getCategoryData($("#entertainment_category_list"), parent_id, true)
      showEntertainmentTab(thiss.data("parent-id"))
    },
  })
}

function validateEntertainmentCategory(thiss, validate = "0") {
  loadingBtn(thiss)
  const searchParams = new URLSearchParams(window.location.search)
  let parent_id = "0"
  if (searchParams.has("parent_id")) {
    parent_id = searchParams.get("parent_id")
  }
  $.ajax({
    type: "post",
    url: amadeusPath + "entertainment_ajax.php",
    data: {
      flag: "validateEntertainmentCategory",
      validate: validate,
      id: thiss.data("category-id"),
    },
    success: function (data) {
      var JsonData = JSON.parse(data)
      loadingBtn(thiss, false)
      if (validate === "0") {
        thiss
          .removeClass("btn-outline-danger")
          .addClass("btn-outline-secondary")
        thiss.attr("onClick", 'validateEntertainmentCategory($(this),"1")')
        thiss.html(useXmltag("RestoreCategory"))
      } else {
        thiss
          .removeClass("btn-outline-secondary")
          .addClass("btn-outline-danger")
        thiss.attr("onClick", "validateEntertainmentCategory($(this))")
        thiss.html(useXmltag("DeleteCategory"))
      }
    },
  })
}

function validateEntertainment(thiss, validate = "0") {
  loadingBtn(thiss)
// console.log(thiss)
  $.ajax({
    type: "post",
    url: amadeusPath + "entertainment_ajax.php",
    data: {
      flag: "validateEntertainment",
      validate: validate,
      id: thiss.data("entertainment-id"),
    },
    success: function (data) {
      var JsonData = JSON.parse(data)
      loadingBtn(thiss, false)
      if (validate === "0") {
        thiss
          .removeClass("btn-outline-danger")
          .addClass("btn-outline-secondary")
        thiss.attr("onClick", 'validateEntertainment($(this),"1")')
        thiss.html(useXmltag("RestoreEntertainment"))
      } else {
        thiss
          .removeClass("btn-outline-secondary")
          .addClass("btn-outline-danger")
        thiss.attr("onClick", "validateEntertainment($(this))")
        thiss.html(useXmltag("DeleteEntertainment"))
      }
    },
  })
}

function getCategoryData(targetTable, parentId = 0, changeUrl = true) {
  if (targetTable.children("thead").length > 0) {
    refreshData(targetTable)
  }

  if (changeUrl) {
    const url = new URL(window.location)
    url.searchParams.delete("category_id")
    if (parentId == 0) {
      url.searchParams.delete("parent_id")
    } else {
      url.searchParams.set("parent_id", parentId)
    }
    window.history.pushState({}, "", url)
  }

  let columns = []
  if (parentId > 0) {
    columns = [
      {
        title: useXmltag("Code"),
        data: "CatId",
      },
      {
        title: useXmltag("SubCategory"),
        data: "CategoryTitle",
      },
      {
        title: useXmltag("Entertainment"),
        data: "SubCategoryLink",
      },
      {
        title: useXmltag("Edit"),
        data: "CategoryEdit",
      },
      {
        title: useXmltag("Delete"),
        data: "CategoryValidate",
      },
    ]
  } else {
    columns = [
      {
        title: useXmltag("Code"),
        data: "CatId",
      },
      {
        title: useXmltag("Category"),
        data: "CategoryTitle",
      },
      {
        title: useXmltag("Entertainment"),
        data: "SubCategoryLink",
      },
      {
        title: useXmltag("Edit"),
        data: "CategoryEdit",
      },
      {
        title: useXmltag("Delete"),
        data: "CategoryValidate",
      },
    ]
  }

  targetTable.DataTable({
    dom: "Bfrtip",
    processing: true,
    serverSide: true,
    scrollCollapse: true,
    info: true,
    paging: true,
    searching: false,
    serverMethod: "post",
    ajax: {
      url: amadeusPath + "entertainment_ajax.php",
      data: {
        flag: "categoryList",
        parent_id: parentId,
        dataTable: true,
      },
    },
    columns: columns,
  })

  getEntertainmentCategories($("#myTab"))
}

function getEntertainmentDataV2(
  targetTable,
  category_id,
  parent_id,
  check_offline,
  check_online,
  changeUrl = true
) {
  var myTabContent = $("#myTabContent")

  myTabContent.find("div:not(:first-child)").remove()

  myTabContent.append(
    "" +
    '<div class="tab-pane fade active show" id="category-div-' +
    category_id +
    '" role="tabpanel" aria-labelledby="category-tab-' +
    category_id +
    '">' +
    '            <div class="col-md-12 bg-white pt-3">\n' +
    '                <button class="btn site-bg-main-color" type="button" data-target="#exampleModal"\n' +
    "                        onclick=\"createNewEntertainmentModal($(this),'" +
    category_id +
    "','" +
    parent_id +
    "','" +
    check_offline +
    "','" +
    check_online +
    "')\">\n" +
    "" +
    useXmltag("NewEntertainment") +
    " \n" +
    "                </button>\n" +
    '                <button class="btn btn-warning" type="button" data-toggle="modal" data-target="#ModalOptions" \n' +
    '                        onclick="AddEntertainmentType(3)">\n' +
    "" +
    useXmltag("Options") +
    " \n" +
    "                </button>\n" +
    "            </div>" +
    " </div>"
  )

  if (targetTable.children("thead").length > 0) {
    refreshData(targetTable)
  }

  if (changeUrl) {
    const url = new URL(window.location)
    url.searchParams.set("category_id", category_id)
    window.history.pushState({}, "", url)
  }

  var columns = [
    {
      title: useXmltag("Code"),
      data: "id",
    },
    {
      title: useXmltag("Title"),
      data: "title",
    },
    {
      title: useXmltag("SubCategory"),
      data: "CategoryTitle",
    },
    {
      title: useXmltag("Price"),
      data: "price",
    },
    {
      title: useXmltag("Gallery"),
      data: "EntertainmentGallery",
    },
    {
      title: useXmltag("AcceptStatus"),
      data: "EntertainmentAcceptedAt",
    },
    {
      title: useXmltag("Edit"),
      data: "EntertainmentEdit",
    },
    {
      title: useXmltag("Delete"),
      data: "EntertainmentDelete",
    },
  ]
  targetTable.DataTable({
    dom: "Bfrtip",
    processing: true,
    serverSide: true,
    scrollCollapse: true,
    info: false,
    paging: false,
    searching: false,
    serverMethod: "post",
    ajax: {
      url: amadeusPath + "entertainment_ajax.php",
      data: {
        flag: "entertainmentList",
        category_id: category_id,
        dataTable: true,
      },
    },
    columns: columns,
  })
}

function closeModal() {
  $(".modal-backdrop").remove()
}

function EntertainmentTypeClick(thiss, value) {
  $('div[data-target="IconBoxSelector"] .border').each(function () {
    $(this).removeClass("active")
  })
  thiss.addClass("active")
  $('input[name="EntertainmentTypeIcon"]').val(value)
}

function EntertainmentTypeEdit(thiss, id) {
  EntertainmentTypeCloseEdit()
  $.ajax({
    type: "post",
    url: libraryPath + "ModalCreatorForEntertainment.php",
    data: {
      Controller: "entertainment",
      Method: "ModalGetEntertainmentTypeData",
      Param: id,
    },
    success: function (data) {
      var JsonData = JSON.parse(data)

      var tr = ""
      $.each(JsonData.data, function (i, item) {
        $('input[name="EntertainmentTypeName"]').val(item.title)
        $(
          'div[data-target="IconBoxSelector"][data-value$="' +
          item.logo +
          '"] .border'
        ).addClass("active")
        $('[data-target="SubmitForm"]').html(useXmltag("Edit"))
        $('[data-target="SubmitForm"]').after(
          '<button data-target="CloseEditForm" type="button" onclick="EntertainmentTypeCloseEdit()" class="btn btn-danger mt-4 ml-2">' +
          useXmltag("Close") +
          "</button>"
        )
        $('[name="FormStatus"]').val(item.id)
      })
    },
  })
}

function ManageAcceptEntertainment(thiss, id) {
  $.ajax({
    type: "post",
    url: amadeusPath + "/entertainment_ajax.php",
    data: {
      flag: "manageAcceptEntertainment",
      action: thiss.data("action"),
      id: id,
    },
    success: function (data) {
      var JsonData = JSON.parse(data)

      console.log(JsonData)
      console.log(thiss.data("action"))
      if (thiss.children("i").hasClass("btn-danger")) {
        thiss.attr("data-action", "reject")
        thiss.children("i").attr("data-original-title", useXmltag("Accepted"))
        thiss.children("i").addClass("btn-success").removeClass("btn-danger")
        thiss.children("i").addClass("fa-check").removeClass("fa-ban")
      } else {
        thiss.attr("data-action", "accept")
        thiss
          .children("i")
          .attr("data-original-title", useXmltag("Disallowshowinssite"))
        thiss.children("i").addClass("btn-danger").removeClass("btn-success")
        thiss.children("i").addClass("fa-ban").removeClass("fa-check")
      }
    },
  })
}

function EntertainmentTypeCloseEdit() {
  $('input[name="EntertainmentTypeName"]').val("")
  $('div[data-target="IconBoxSelector"] .border').each(function () {
    $(this).removeClass("active")
  })
  $('input[name="EntertainmentTypeIcon"]').val("")
  $('[data-target="SubmitForm"]').html(useXmltag("AddItem"))
  $('[data-target="CloseEditForm"]').remove()
  $('[name="FormStatus"]').val("new")
}

function GetEntertainmentTypeData() {
  $.ajax({
    type: "post",
    url: libraryPath + "ModalCreatorForEntertainment.php",
    data: {
      Controller: "entertainment",
      Method: "ModalGetEntertainmentTypeData",
      Param: "",
    },
    success: function (data) {
      var JsonData = JSON.parse(data)

      var tr = ""
      $.each(JsonData.data, function (i, item) {
        tr =
          tr +
          "<tr>" +
          "<td>" +
          item.title +
          "</td>" +
          '<td><span class="mdi ' +
          item.logo +
          '"></span></td>' +
          '<td><button onclick="EntertainmentTypeEdit($(this),' +
          item.id +
          ')" class="btn btn-info"><span class="fa fa-edit"></span></button></td>' +
          '<td><button onclick="SubmitRemoveEntertainmentType(' +
          item.id +
          ')" class="btn btn-danger"><span class="fa fa-remove"></span></button></td>' +
          "</tr>"
      })
      $("#AllEntertainmentType").html(tr)
    },
  })
}

function SubmitNewEntertainmentType() {
  var FilterData = $("#NewEntertainmentType").serialize()
  $.ajax({
    type: "post",
    url: libraryPath + "ModalCreatorForEntertainment.php",
    data: {
      Controller: "entertainment",
      Method: "ModalAddType",
      Param: FilterData,
    },
    success: function (data) {
      var JsonData = JSON.parse(data)

      var res = JsonData.status.split(":")
      if (JsonData.status.indexOf("success") > -1) {
        $.alert({
          title: useXmltag("Entertainment"),
          // icon: 'fa fa-sign-in',
          content: res[1],
          rtl: true,
          type: "green",
        })
      } else {
        $.alert({
          title: useXmltag("Entertainment"),
          // icon: 'fa fa-sign-in',
          content: res[1],
          rtl: true,
          type: "red",
        })
      }
      $('[name="EntertainmentTypeName"]').val("")
      $('[name="EntertainmentTypeIcon"]').val("")
      $('div[data-target="IconBoxSelector"] .border').each(function () {
        $(this).removeClass("active")
      })
      GetEntertainmentTypeData()
    },
  })
}

function SubmitRemoveEntertainmentType(id) {
  $.confirm({
    theme: "bootstrap", // 'material', 'bootstrap'
    title: useXmltag("Delete"),
    icon: "fa fa-trash",
    content: useXmltag("AreYouSureDelete"),
    rtl: true,
    closeIcon: true,
    type: "orange",
    buttons: {
      confirm: {
        text: useXmltag("Approve"),
        btnClass: "btn-green",
        action: function () {
          $.ajax({
            type: "post",
            url: libraryPath + "ModalCreatorForEntertainment.php",
            data: {
              Controller: "entertainment",
              Method: "ModalRemove",
              Param: id,
            },
            success: function (data) {
              var JsonData = JSON.parse(data)

              var res = JsonData.status.split(":")
              if (JsonData.status.indexOf("success") > -1) {
                $.alert({
                  title: useXmltag("Entertainment"),
                  // icon: 'fa fa-sign-in',
                  content: res[1],
                  rtl: true,
                  type: "green",
                })
              } else {
                $.alert({
                  title: useXmltag("Entertainment"),
                  // icon: 'fa fa-sign-in',
                  content: res[1],
                  rtl: true,
                  type: "red",
                })
              }
              GetEntertainmentTypeData()
            },
          })
        },
      },
      cancel: {
        text: useXmltag("Optout"),
        btnClass: "btn-orange",
      },
    },
  })
}

var hideInProgress = false
var showModalId = ""

function showModal(elementId) {
  if (hideInProgress) {
    showModalId = elementId
  } else {
    $("#" + elementId).modal("show")
  }
}

function hideModal(elementId) {
  hideInProgress = true
  $("#" + elementId).on("hidden.bs.modal", hideCompleted)
  $("#" + elementId).modal("hide")

  function hideCompleted() {
    hideInProgress = false
    if (showModalId) {
      showModal(showModalId)
    }
    showModalId = ""
    $("#" + elementId).off("hidden.bs.modal")
  }
}

function AddEntertainmentType(LevelId) {
  $.ajax({
    type: "post",
    url: libraryPath + "ModalCreatorForEntertainment.php",
    data: {
      Controller: "entertainment",
      Method: "ModalShowAddType",
      Param: LevelId,
    },
    success: function (data) {
      $("#modalOptions").html(data)
      showModal("modalOptions")

      GetEntertainmentTypeData()
      $(".select2").select2()
    },
  })
}

function editEntertainmentCategoryModal(thiss) {
  loadingBtn(thiss)
  var categoryId = thiss.data("category-id")
  $.ajax({
    type: "POST",
    url: amadeusPath + "entertainment_ajax.php",
    data: {
      flag: "categoryList",
      id: categoryId,
    },
    success: function (response) {
      loadingBtn(thiss, false)
      const fullData = JSON.parse(response)
      const url = new URL(window.location)

      var page_parent_id = 0
      if (url.searchParams.has("parent_id")) {
        page_parent_id = url.searchParams.get("parent_id")
      }

      $(thiss.data("target")).modal("show")
      var modalBody = $(thiss.data("target")).find(".modal-body")
      var modalHeader= $(thiss.data('target')).find('.modal-header').find('h5');

      var newHtml = ""
      newHtml =
        '<div class="col-md-12 d-flex flex-wrap">' +
        '<form class="w-100 d-flex flex-wrap" method="post" id="formSubmitEditEntertainmentCategory" action="' +
        amadeusPath +
        "entertainment_ajax.php" +
        '"> '
      newHtml += inputLoop("", "flag", "editEntertainmentCategory", true)
      newHtml += inputLoop("CategoryId", "id", fullData.CategoryId, true)
      newHtml += inputLoop("", "validate", "1", true)
      newHtml += inputLoop(
        useXmltag("EntertainmentTitle"),
        "title",
        fullData.CategoryTitle,
        false,
        {
          size: "col-md-12",
        }
      )
      newHtml += "</form></div>"
      $(thiss.data("target"))
        .find('button[data-type="submit"]')
        .removeClass("d-none")
        .attr("onClick", "editEntertainmentCategory($(this))")
        .attr("data-target", "#exampleModal")
        .attr("data-id", categoryId)

      modalBody.html(newHtml)
      modalHeader.html(useXmltag("EditCategory"));
    },
  })
}

function GetEntertainmentGalleryData(entertainment_id) {
  $.ajax({
    type: "post",
    url: amadeusPath + "/entertainment_ajax.php",
    data: {
      flag: "GetEntertainmentGalleryData",
      entertainment_id: entertainment_id,
    },
    success: function (data) {
      var JsonData = JSON.parse(data)

      var tr = ""
      var counter = 1
      $.each(JsonData.data, function (i, item) {
        tr =
          tr +
          "<tr>" +
          "<td>" +
          counter +
          "</td>" +
          '<td><img src="..\\pic\\entertainment\\' +
          item.file +
          '" alt=""></td>' +
          '<td><button onclick="SubmitRemoveEntertainmentGallery(' +
          item.id +
          ',$(this))" class="btn btn-danger"><span class="fa fa-remove"></span></button></td>' +
          "</tr>"
        counter = counter + 1
      })
      $("#AllEntertainmentGallery").html(tr)
    },
  })
}

function entertainmentGalleryModal(thiss, parent_id, entertainment_id) {
  loadingBtn(thiss)

  $(thiss.data("target")).modal("show")
  $(thiss.data("target")).find('button[data-type="submit"]').addClass("d-none")
  var modalBody = $(thiss.data("target")).find(".modal-body")
  var modalHeader= $(thiss.data('target')).find('.modal-header').find('h5');

  var newHtml = ""
  newHtml =
    ' <div class="row">\n' +
    '        <div class="col-sm-12">\n' +
    '            <div class="white-box col-md-12">\n' +
    '                <h3 class="box-title m-b-0"> ' +
    useXmltag("NasimBeheshtGallery") +
    " </h3>\n" +
    "\n" +
    '                <p class="text-muted m-b-30 textPriceChange">\n' +
    "                </p>\n" +
    "\n" +
    '                <div class="col-md-12">\n' +
    '                    <div id="actions" class="col-sm-12  p-0">\n' +
    "                        <!-- HTML heavily inspired by https://blueimp.github.io/jQuery-File-Upload/ -->\n" +
    '                        <div class="col-lg-7 p-0">\n' +
    "\n" +
    "\n" +
    '                            <div class="btn-group" role="group" aria-label="Basic example">\n' +
    '                                <button type="button" class="btn btn-success fileinput-button dz-clickable"><i class="fa fa-plus"></i>' +
    useXmltag("AddNewFile") +
    "</button>\n" +
    '                                <button data-dz-remove type="submit" class="btn site-bg-main-color start"><i class="fa fa-upload"></i> ' +
    useXmltag("StartUpload") +
    "</button>\n" +
    '                                <button type="reset" class="btn btn-warning cancel">' +
    useXmltag("CancelUpload") +
    "</button>\n" +
    "                            </div>\n" +
    "\n" +
    "\n" +
    "                        </div>\n" +
    "\n" +
    '                        <div class="col-lg-5">\n' +
    "                            <!-- The global file processing state -->\n" +
    '                            <span class="fileupload-process">\n' +
    '        <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0"\n' +
    '             aria-valuemax="100" aria-valuenow="0">\n' +
    '          <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress=""></div>\n' +
    "        </div>\n" +
    "      </span>\n" +
    "                        </div>\n" +
    "                    </div>\n" +
    '                    <div class="table table-striped files" id="previews">\n' +
    '                        <div id="template" class="file-row dz-image-preview">\n' +
    "                            <!-- This is used as the file preview template -->\n" +
    "                            <div>\n" +
    '                                <span class="preview"><img data-dz-thumbnail></span>\n' +
    "                            </div>\n" +
    "                            <div>\n" +
    '                                <p class="name" data-dz-name></p>\n' +
    '                                <strong class="error text-danger" data-dz-errormessage></strong>\n' +
    "                            </div>\n" +
    "                            <div>\n" +
    '                                <p class="size" data-dz-size></p>\n' +
    '                                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0"\n' +
    '                                     aria-valuemax="100" aria-valuenow="0">\n' +
    '                                    <div class="progress-bar progress-bar-success" style="width:0%;"\n' +
    "                                         data-dz-uploadprogress></div>\n" +
    "                                </div>\n" +
    "                            </div>\n" +
    '                            <div class="btn-actions">\n' +
    '                                <div class="btn-group" role="group" aria-label="Basic example">\n' +
    '                                    <button type="button" class="btn site-bg-main-color start"><i class="fa fa-upload"></i> ' +
    useXmltag("StartUpload") +
    "</button>\n" +
    '                                    <button data-dz-remove type="button" class="btn btn-warning cancel"><i class="fa fa-ban"></i> ' +
    useXmltag("CancelUpload") +
    "</button>\n" +
    "                                </div>\n" +
    "\n" +
    "                            </div>\n" +
    "                        </div>\n" +
    "                    </div>\n" +
    "\n" +
    "                </div>\n" +
    "\n" +
    "\n" +
    "            </div>\n" +
    "\n" +
    "        </div>\n" +
    "    </div>" +
    "" +
    '<div class="row">\n' +
    "\n" +
    '        <div class="col-sm-12">\n' +
    '            <div class="white-box">\n' +
    '                <p class="text-muted m-b-30">\n' +
    "                </p>\n" +
    '                <div class="table-responsive">\n' +
    '                    <table class="table table-hover GalleryTable">\n' +
    "                        <thead>\n" +
    "                        <tr>\n" +
    '                            <th scope="col">#</th>\n' +
    '                            <th scope="col">' +
    useXmltag("Image") +
    "</th>\n" +
    '                            <th scope="col">' +
    useXmltag("Action") +
    "</th>\n" +
    "                        </tr>\n" +
    "                        </thead>\n" +
    '                        <tbody id="AllEntertainmentGallery">\n' +
    "\n" +
    "\n" +
    "                        </tbody>\n" +
    "                    </table>\n" +
    "                </div>\n" +
    "            </div>\n" +
    "        </div>\n" +
    "\n" +
    "    </div>" +
    ""

  modalBody.html(newHtml)
  modalHeader.html(useXmltag("EditGallery"));
  loadingBtn(thiss, false)

  // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
  var previewNode = document.querySelector("#template")
  previewNode.id = ""
  var previewTemplate = previewNode.parentNode.innerHTML
  previewNode.parentNode.removeChild(previewNode)

  var myDropzone = new Dropzone("#previews", {
    // Make the whole body a dropzone
    url: amadeusPath + "/entertainment_ajax.php", // Set the url
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    addRemoveLinks: true,
    dictRemoveFileConfirmation: true,
    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: "#previews", // Define the container to display the previews
    clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.
  })

  myDropzone.on("addedfile", function (file) {
    // Hookup the start button
    file.previewElement.querySelector(".start").onclick = function () {
      myDropzone.enqueueFile(file)
    }
  })

  // Update the total progress bar
  myDropzone.on("totaluploadprogress", function (progress) {
    document.querySelector("#total-progress .progress-bar").style.width =
      progress + "%"
  })

  myDropzone.on("sending", function (file) {
    // Show the total progress bar when upload starts
    document.querySelector("#total-progress").style.opacity = "1"
    // And disable the start button
    file.previewElement
      .querySelector(".start")
      .setAttribute("disabled", "disabled")
  })

  // Hide the total progress bar when nothing's uploading anymore
  myDropzone.on("queuecomplete", function (progress) {
    document.querySelector("#total-progress").style.opacity = "0"
  })

  // Setup the buttons for all transfers
  // The "add files" button doesn't need to be setup because the config
  // `clickable` has already been specified.
  document.querySelector("#actions .start").onclick = function () {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
  }
  document.querySelector("#actions .cancel").onclick = function () {
    myDropzone.removeAllFiles(true)
  }
  myDropzone.on("success", function (file, response) {
    var JsonData = JSON.parse(response)

    $(file.previewTemplate).append(
      '<span class="server_file">' + JsonData.FileGalleryId + "</span>"
    )
  })
  // document.querySelector("#actions .delete").onclick = function () {
  //     console.log(JsonData);
  // };
  myDropzone.on("removedfile", function (file) {
    var server_file = $(file.previewTemplate).children(".server_file").text()

    SubmitRemoveEntertainmentGallery(server_file)
  })

  myDropzone.on("sending", function (file, xhr, formData) {
    formData.append("flag", "insert_Gallery")
    formData.append("id", entertainment_id)
  })
  myDropzone.on("success", function (file, response) {
    GetEntertainmentGalleryData(entertainment_id)
  })

  GetEntertainmentGalleryData(entertainment_id)
}

function SubmitRemoveEntertainmentGallery(GalleryId, IsTable = false) {
  $.ajax({
    type: "post",
    url: amadeusPath + "entertainment_ajax.php",
    data: {
      GalleryId: GalleryId,
      flag: "RemoveSingleGallery",
    },
    success: function (data) {
      var JsonData = JSON.parse(data)
      if (JsonData.result_status == "success") {
        if (IsTable != false) {
          IsTable.parent().parent().remove()
        }
      } else {
        $.toast({
          heading: useXmltag("RecordChanges"),
          text: JsonData.result_message,
          position: "top-right",
          loaderBg: "#fff",
          icon: "error",
          hideAfter: 3500,
          textAlign: "right",
          stack: 6,
        })
      }
    },
  })
}

function editEntertainmentModal(thiss, parent_id, entertainment_id) {
  // loadingBtn(thiss);
// console.log(thiss)
  $.ajax({
    type: "POST",
    url: amadeusPath + "entertainment_ajax.php",
    data: {
      flag: "categoryList",
      parent_id: parent_id,
    },
    success: function (response) {
      $.ajax({
        type: "POST",
        url: amadeusPath + "entertainment_ajax.php",
        data: {
          flag: "getEntertainmentTypes",
        },
        success: function (typeResponse) {
          $.ajax({
            type: "POST",
            url: amadeusPath + "entertainment_ajax.php",
            data: {
              flag: "GetEntertainmentData",
              CategoryId: "",
              EntertainmentId: entertainment_id,
              data_table: true,
            },
            success: function (entertainmentResponse) {
              var entertainment = JSON.parse(entertainmentResponse)

              $.ajax({
            type: "POST",
            url: amadeusPath + "entertainment_ajax.php",
                data: {
                  flag: "getEntertainmentCountries",
                  filter: "false",
                },
          success: function (countryResponse) {
            $.ajax({
              type: "POST",
              url: amadeusPath + "entertainment_ajax.php",
              data: {
                flag: "getEntertainmentCurrency",
                filter: "false",

              },
              success: function(currencyResponse) {
                $.ajax({
                  type: "POST",
                  url: amadeusPath + "entertainment_ajax.php",
                  data: {
                    flag: "getEntertainmentCities",
                    country_id: entertainment.data.category_id,
                    filter: "false",
                  },
                  success: function(cityResponse) {
                    var cities = JSON.parse(cityResponse)

                    var categories = JSON.parse(response)
                    var countries = JSON.parse(countryResponse)
                    var currency = JSON.parse(currencyResponse)
                    var categoriesArray = ""
                    var currencyArray = ""
                    var countriesArray = ""
                    $.each(categories, function(index, value) {

                      categoriesArray +=
                        "<option " +
                        (value.CategoryId === entertainment.data.category_id
                          ? "selected"
                          : "") +
                        " value='" +
                        value.CategoryId +
                        "' > " +
                        value.CategoryTitle +
                        "</option>"
                    })

                    $.each(countries, function(index, value) {
                      countriesArray +=
                        "<option " +
                        (value.id === entertainment.data.country_id
                          ? "selected"
                          : "") +
                        " value='" +
                        value.id +
                        "' > " +
                        value.name +
                        "</option>"
                    })
                    $.each(currency, function(index, value) {
                      var currency_names = lang == 'fa' ? value.CurrencyTitle : value.CurrencyTitleEn
                      currencyArray +=
                        "<option " +
                        (value.CurrencyCode === entertainment.data.currency_type
                          ? "selected"
                          : "") +
                        " value='" +
                        value.CurrencyCode +
                        "' > " + currency_names +
                        "</option>"
                    })

                    var citiesArray = ""
                    $.each(cities, function(index, value) {
                      citiesArray +=
                        "<option " +
                        (value.id === entertainment.data.city_id
                          ? "selected"
                          : "") +
                        " value='" +
                        value.id +
                        "' > " +
                        value.name +
                        "</option>"
                    })


                    $(thiss.data("target")).modal("show")
                    var modalBody = $(thiss.data("target")).find(".modal-body")
                    var modalHeader = $(thiss.data('target')).find('.modal-header').find('h5');

                    var newHtml = ""
                    newHtml =
                      '<div class="col-md-12 d-flex flex-wrap">' +
                      '<form class="w-100 d-flex flex-wrap" enctype="multipart/form-data" method="post" id="formSubmitEditEntertainment" action="' +
                      amadeusPath +
                      "entertainment_ajax.php" +
                      '"> '
                    newHtml += inputLoop("", "flag", "EditEntertainment", true)

                    newHtml += inputLoop(
                      "",
                      "category_id",
                      entertainment.data.category_id,
                      true
                    )
                    newHtml += inputLoop("", "id", entertainment.data.id, true)
                    newHtml += inputLoop(
                      useXmltag("Title"),
                      "title",
                      entertainment.data.title,
                      false,
                      {
                        size: "col-md-6",
                      }
                    )
                    // newHtml += inputLoop(
                    //   useXmltag("TitleEnglish"),
                    //   "title_en",
                    //   entertainment.data.title_en,
                    //   false,
                    //   {
                    //     size: "col-md-6",
                    //   }
                    // )
                    newHtml +=
                       '<div class="col-md-6 d-flex flex-wrap mb-4">\n' +
                       '<label for="title_en" class="control-label mb-2">'+ useXmltag("TitleEnglish") +'</label>\n' +
                       '<input type="text" class="form-control"\n' +
                       'value="'+entertainment.data.title_en+'"\n' +
                       'data-id="title_en"\n' +
                       'id="title_en" name="title_en[]"\n' +
                       'placeholder="'+ useXmltag("TitleEnglish") +'">\n' +
                       '</div>'
                    newHtml += inputLoop(
                      useXmltag("Price"),
                      "price",
                      entertainment.data.price,
                      false,
                      {
                        size: "col-md-4",
                      }
                    )
                    newHtml += inputLoop(
                      useXmltag("ArziPrice"),
                      "currency_price",
                      entertainment.data.currency_price,
                      false,
                      {
                        size: "col-md-4",
                      }
                    )
                    newHtml +=
                      '<div class="col-md-4  mb-4">\n' +
                      '<label for="EntertainmentCategoryTitle" class="control-label float-right mb-2">' +
                      useXmltag("Typecurrency") +
                      "</label>" +
                      '<select name="currency_type" id="currency_type" class="form-control">\n' +
                       '<option value="">انتخاب کنید....</option>\n' +
                       currencyArray +
                      "</select>" +
                      "</div>"
                    newHtml += inputLoop(
                      useXmltag("Discount"),
                      "discount_price",
                      entertainment.data.discount_price,
                      false,
                      {
                        size: "col-md-4",
                      }
                    )

                    var types = JSON.parse(typeResponse)

                    var typeArray = ""

                    $.each(types, function(index, value) {
                      typeArray +=
                        "<option " +
                        (entertainment.data.getEntertainmentTypes.indexOf(value.id) >
                        -1
                          ? "selected"
                          : "") +
                        " value='" +
                        value.id +
                        "' > " +
                        value.title +
                        "</option>"
                    })

                    newHtml +=
                      '<div class="col-md-4  mb-4">\n' +
                      '<label for="EntertainmentSubCategory" class="control-label float-right mb-2">' +
                      useXmltag("InsertIn") +
                      "</label>" +
                      '<select required name="category_id" id="EntertainmentSubCategory" class="form-control">\n' +
                      categoriesArray +
                      "</select>" +
                      "</div>"
                    newHtml +=
                      '<div class="col-md-4  mb-4">\n' +
                      '<label for="EntertainmentCountryTitle" class="control-label float-right mb-2">' +
                      useXmltag("Country") +
                      "</label>" +
                      '<select required onchange="getSelectBoxCities($(this).val())" name="EntertainmentCountryTitle[]" id="EntertainmentCountryTitle" class="form-control">\n' +
                      countriesArray +
                      "</select>" +
                      "</div>"

                    newHtml +=
                      '<div class="col-md-4  mb-4">\n' +
                      '<label for="EntertainmentCityTitle" class="control-label float-right mb-2">' +
                      useXmltag("City") +
                      "</label>" +
                      '<select required name="EntertainmentCityTitle[]" id="EntertainmentCityTitle" class="form-control">\n' +
                      '<option disabled selected value="0">' + useXmltag("ChoseOption") + '</option>\n' +

                      citiesArray +
                      "</select>" +
                      "</div>"

                    newHtml +=
                      '<div class="col-md-4  mb-4">\n' +
                      '<label for="EntertainmentTypes" class="control-label float-right mb-2">' +
                      useXmltag("Options") +
                      "</label>" +
                      '<select name="EntertainmentTypes[]" multiple="multiple" id="EntertainmentTypes" class="form-control Select2Tag">\n' +
                      typeArray +
                      "</select>" +
                      "</div>"

                    var entertainmentDataTable = JSON.parse(
                      entertainment.data.datatable
                    )
                    var entertainmentDataTableArray = ""
                    $.each(entertainmentDataTable, function(index, value) {
                      entertainmentDataTableArray +=
                        '    <div data-target="BaseDataTableDiv" class="col-sm-12 d-flex flex-wrap p-0 form-group">\n' +
                        '        <div class="col-md-3 pr-0">\n' +
                        '            <input data-parent="DataTableValues" data-target="title" name="DataTable[' +
                        index +
                        '][title]" placeholder="' +
                        useXmltag("Title") +
                        '" value="' +
                        value.title +
                        '" class="form-control"\n' +
                        '                  type="text">\n' +
                        "        </div>\n" +
                        '        <div class="col-md-8">\n' +
                        '            <input data-parent="DataTableValues" data-target="body" name="DataTable[' +
                        index +
                        '][body]" placeholder="' +
                        useXmltag("Description") +
                        '" value="' +
                        value.body +
                        '" class="form-control"\n' +
                        '                  type="text">\n' +
                        "        </div>\n" +
                        '        <div class="col-md-1 d-flex flex-wrap p-0">\n' +
                        '            <div class="col-md-6 p-0">\n' +
                        '                <button type="button" onclick="AddDataTable()" class="btn form-control btn-success">\n' +
                        '                    <span class="fa fa-plus"></span>\n' +
                        "                </button>\n" +
                        "            </div>\n" +
                        '            <div class="col-md-6 p-0">\n' +
                        '                <button onclick="RemoveDataTable($(this))" type="button" class="btn form-control btn-danger">\n' +
                        '                    <span class="fa fa-remove"></span>\n' +
                        "                </button>\n" +
                        "            </div>\n" +
                        "        </div>\n" +
                        "    </div>\n"
                    })

                    newHtml +=
                      '<div class="form-group d-flex flex-wrap col-sm-12 DynamicDataTable">\n' +
                      '    <span class="control-label float-right mb-2 col-md-12 p-0">' +
                      useXmltag("IntroducingServices") +
                      "</span>\n" +
                      entertainmentDataTableArray +
                      "</div>"


                    newHtml += `
              <div class="richtext-field">
                  <label class="richtext-label">
                      ${useXmltag("Description")}
                  </label>
              
                  <textarea
                      id="description"
                      name="description[]"
                      class="ckeditor"
                      dir="rtl"
                      rows="6">
                      ${entertainment.data.description}
                  </textarea>
              </div>
              `;

                    newHtml +=
                      '<div class="form-group col-sm-12">\n' +
                      '    <label for="video" class="control-label float-right">' +
                      useXmltag("Video") +
                      "</label>\n" +
                      '    <textarea id="video" name="video[]" class="form-control">' +
                      entertainment.data.video +
                      "</textarea>\n" +
                      "</div>"

                    newHtml +=
                      '<div class="form-group col-lg-6 col-md-6 col-xs-6 col-sm-6">\n' +
                      '    <label for="picEntertainment" class="control-label float-right">' +
                      useXmltag("Indeximg") +
                      "</label>\n" +
                      '    <input type="file" name="picEntertainment" id="picEntertainment" class="dropify" data-height="100">\n' +
                      "</div>"

                    newHtml +=
                      '<div class="form-group col-lg-6 col-md-6 col-xs-6 col-sm-6">\n' +
                      '    <label for="package" class="control-label float-right">' +
                      useXmltag("Packageselection") +
                      "</label>\n" +
                      '    <input type="file" name="package" id="package" class="dropify" data-height="100">\n' +
                      "</div>"

                    newHtml += "</form></div>"

                    modalBody.html(newHtml)
                    if (typeof CKEDITOR !== 'undefined') {
                      CKEDITOR.replace('description', {
                      });
                    }
                    modalHeader.html(useXmltag("EditEntertainment"));
                    getSelectBoxCities(entertainment.data.country_id, entertainment.data.city_id)
                    $(".Select2Tag").select2()
                    $(thiss.data("target"))
                      .find('button[data-type="submit"]')
                      .removeClass("d-none")
                      .attr("onClick", "submitEditEntertainment($(this))")
                      .attr("data-target", "#exampleModal")
                      .attr("data-category-id", entertainment.data.CategoryId)
                      .attr("data-parent-id", parent_id)

                    loadingBtn(thiss, false)

                  }
                })
              },
             })

          }
              })
            },
            error: function (e) {
              // error callback
              console.log(e)
              alert("insert one type")
            },
          })
        },
      })
    },
  })
}

function submitEditEntertainment(thiss) {

  // var FilterData =  new FormData($('#formSubmitNewEntertainment'));
  let form2 = $("#formSubmitEditEntertainment")
  if (!form2.validate().form()) return false;

  if (typeof CKEDITOR !== 'undefined') {
    for (let instance in CKEDITOR.instances) {
      CKEDITOR.instances[instance].updateElement();
    }
  }
  loadingBtn(thiss)
  // you can't pass Jquery form it has to be javascript form object
  // var FilterData = new FormData(form[0]);

  // console.log(FilterData);
  const searchParams = new URLSearchParams(window.location.search)
  let parent_id = "0"
  if (searchParams.has("parent_id")) {
    parent_id = searchParams.get("parent_id")
  }
  form2.ajaxSubmit({
    type: "post",
    url: amadeusPath + "entertainment_ajax.php",
    enctype: "multipart/form-data",
    processData: false,
    contentType: false,
    data: {
      flag: "EditEntertainment",
    },
    success: function (data) {
      var JsonData = JSON.parse(data)
      console.log(JsonData)
      $(thiss.data("target")).modal("hide")
      loadingBtn(thiss, false)

      getEntertainmentDataV2(
        $("#entertainment_category_list"),
        thiss.data("category-id"),
        thiss.data("parent-id")
      )
    },
  })
}

function submitOpenedModal(targetForm, page_parent_id) {
  var FilterData = targetForm.serialize()

  $.ajax({
    type: "post",
    url: libraryPath + "entertainment_ajax.php",
    data: {
      Param: FilterData,
    },
    success: function (data) {
      var JsonData = JSON.parse(data)
      submitFunction
    },
  })
}

function ToNumbric(ThisNumber) {
  return ThisNumber.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
}

function GetEntertainmentData(country_id=null,city_id=null,category_id = null, is_request = null, Id = null, _this = null,filter=false ) {
  console.log('1')
  window.history.pushState(
    "object or string",
    "Title",
    $('span[data-target="PageUrl"]').attr("data-value") +
    "/resultEntertainment/" +
    country_id+"/"+city_id+"/"+category_id
    // +"&is_request="+is_request
  )
  console.log('2')
  $("#url_category_id").val(category_id)
  console.log('3')
  if(filter){
    console.log('4')
    if(!category_id){
      console.log('5')
      $('.alert[role="alert"]').remove()
      console.log('6')
      $(".RepeatableDiv").addClass("d-none")
      console.log('7')
      $(".BaseDiv").append(
        '<div class="alert alert-danger" role="alert">' +
        '  <h6 class="alert-heading mb-2 "><span class="fa fa-exclamation-triangle ml-2  "></span>' +
        useXmltag("NoInformationFound")+
        "</h6>" +

        "</div>"
      )
      return false;
    }
  }
  console.log('8')

  if (_this && _this.length) {
    loadingToggle(_this)
  }

  console.log('9')

  console.log(country_id , city_id , category_id , is_request ,Id )
  $.ajax({
    type: "post",
    url: amadeusPath + "entertainment_ajax.php",
    data: {
      country_id: country_id,
      city_id: city_id,
      category_id: category_id,
      is_request: is_request,
      EntertainmentId: Id,
      flag: "GetEntertainmentData",
    },
    success: function (data) {


      if (_this && _this.length) {
        loadingToggle(_this, false)
      }
      $('select.select2[data-target="value"]').each(function () {
        if ($(this).data("select2")) {
          $(this).select2("destroy")
        }
      })
      var JsonData = JSON.parse(data)
      var MinEntertainmentPrice = ""
      var MaxEntertainmentPrice = ""
      var RepeatableDiv = $(".RepeatableDiv:last-child")
        .addClass("d-none")
        .clone()

      if (JsonData.result_status == "success") {
        var RepeatableDiv = $(".RepeatableDiv.counter-0").clone()
        $(".RepeatableDiv").remove()
        RepeatableDiv.attr(
          "class",
          RepeatableDiv.attr("class").replace(/\bcounter-\d+\b/g, "counter-0")
        )

        var counter = 0
        $(".BaseDiv").find('div[role="alert"]').remove()

        $.each(JsonData.data, function (i, item) {
          var discountPrice = item.discountPrice

          $(".BaseDiv").append(RepeatableDiv.removeClass("d-none"))

          $(".RepeatableDiv.counter-" + counter)
            .find('[data-mode="ajax"]')
            .each(function () {
              var Target = $(this).attr("data-target")
              if (Target == "BaseUrl") {
                if (item.is_request == "0") {
                  var url = amadeusPathByLang + "detailEntertainment/" + item.id
                  $(this).find("a").attr("href", url)
                } else {
                  var click = 'sendSubmitRequest('+ item.id +')'

                  $(this).find("div.form-append").html(
                    '<form id="sendDataEntetainment'+item.id+'" method="POST" action="'+amadeusPathByLang+'submitRequest" class="sendDataEntetainment" >' +
                    '<input type="hidden" name="entetainmentId" value="'+item.id+'">' +
                    "</input>" +
                    '<input type="hidden" name="serviceName" value="entertainment">' +
                    "</input>"
                  )

                  $(this).find("a").attr("onclick", click)
                  $(this).find("a.intertainment-detail").removeAttr("href")
                }

              } else {
                if ($(this).find('select[data-target="value"]').length) {
                  $(this)
                    .find(
                      'select[data-target="value"] option[value="' +
                      item[Target] +
                      '"]'
                    )
                    .attr("selected", "selected")
                } else {
                  if ($(this).find('img[data-target="value"]').length) {
                    $(this)
                      .find('[data-target="value"]')
                      .attr(
                        "src",
                        $(this).find('[data-target="value"]').attr("data-src") +
                        item[Target]
                      )
                  } else {
                    $(this).find('[data-target="value"]').html(item[Target])
                  }
                }
                if ($(this).find(".discountPrice").length) {
                  if (JsonData.discount == 0 && item.discount_price == 0) {
                    var number_format_price=number_format(item.price);
                    console.log('number_format_price' , number_format_price)
                    $(this)
                      .find(".discountPrice")
                      .html(
                        '<span class="float-right">' +
                        useXmltag("Startprice") +
                        '</span><span  class="d-flex font-weight-bolder font-15">' +
                        number_format_price +
                        "</span>"
                      )
                    console.log($(this))
                  } else {

                    $(this)
                      .find(".discountPrice")
                      .html(
                        '<span class="d-flex">' +
                        useXmltag("Startprice") +
                        '</span>' +
                        '<div class="d-flex">' +
                        '<strike class="strikePrice">' +
                        '<span class="currency priceOff CurrencyCal ThisPrice">' +
                        "<span class='d-flex text-muted'>" +
                        number_format(item.price) +
                        "</span>" +
                        "</span>" +
                        "</strike>" +
                        "<span class='d-flex mr-3 font-weight-bolder font-15'>" +
                        number_format(discountPrice)+
                    "</span>" +
                        "</div>"

                      )
                  }
                }
              }
            })
          $(".RepeatableDiv.counter-" + counter)
            .find('[data-mode="parentAjax"]')
            .each(function () {
              var Target = $(this).attr("data-target")
              if (Target == "discount") {

                if (JsonData[Target] != 0 || item.discount_price != 0) {

                  let temp_this = $(this).find('[data-target="value"]')
                  temp_this.removeClass("d-none")

                  if (item.discount_price !== "0") {
                    temp_this.html(Math.round(item.discount_price) + "%")
                  } else {
                    temp_this.html(Math.round(JsonData[Target]) + "%")
                  }
                } else {
                  $(this).addClass("d-none")
                  $(this).find('[data-target="value"]').addClass("d-none")
                }
              }
            })

          MinEntertainmentPrice = parseInt(item.MinEntertainmentPrice)
          MaxEntertainmentPrice = parseInt(item.MaxEntertainmentPrice)

          RepeatableDiv = $(".RepeatableDiv:last-child").clone()
          RepeatableDiv.removeClass("counter-" + counter)
          counter = counter + 1
          RepeatableDiv.addClass("counter-" + counter)
        })
      } else {
        $('.alert[role="alert"]').remove()
        $(".RepeatableDiv").addClass("d-none")
        // $(".BaseDiv").append(
        //   '<div class="alert alert-danger" role="alert">' +
        //   '  <h6 class="alert-heading mb-2 "><span class="fa fa-exclamation-triangle ml-2  "></span>' +
        //   JsonData.result_status[0] +
        //   "</h6>" +
        //   "  <p>" +
        //   JsonData.result_message[0] +
        //   "</p>" +
        //   "</div>"
        // )
        // $(this).parent().removeClass('BaseDiv');
        $('#result').removeClass('BaseDiv');
        $('#result').addClass('BaseDivFullCapacity');
        $(".BaseDivFullCapacity").html("");
        $(".BaseDivFullCapacity").append(
          '<div id="show_offline_request">' +
          '<div class="fullCapacity_div">' +
          JsonData.result_status +
          "  <h2>" +
          JsonData.result_message[0] +
          "</h2>" +
          "</div>" +
          "</div>"
        )
      }

      $("#slider-range").slider({
        range: true,
        min: MinEntertainmentPrice,
        max: MaxEntertainmentPrice,
        step: 50000,
        animate: true,
        values: [MinEntertainmentPrice, MaxEntertainmentPrice],
        slide: function (event, ui) {
          let minRange = ui.values[0]
          let maxRange = ui.values[1]

          $(".filter-price-text span:nth-child(2) i").html(addCommas(minRange))
          $(".filter-price-text span:nth-child(1) i").html(addCommas(maxRange))

          let hotels = $(".RepeatableDiv")
          hotels
            .hide()
            .filter(function () {
              let price = parseInt($(this).find(".ThisPrice").text(), 10)
              return price >= minRange && price <= maxRange
            })
            .show()
        },
      })

      $(".filter-price-text span:nth-child(2) i").html(
        addCommas(MinEntertainmentPrice)
      )
      $(".filter-price-text span:nth-child(1) i").html(
        addCommas(MaxEntertainmentPrice)
      )

      // $("#EntertainmentCategory").val(JsonData.data[0].BaseCategoryId).change()

      $('select.select2[data-target="value"]').each(function () {
        if (!$(this).data("select2")) {
          $(this).select2()
        }
      })

      $(".silence_span span").html($(".RepeatableDiv:not(.d-none)").length)

      $(".ThisPriceNumber").each(function () {
        var aa = $(this).text()
        $(this).html(number_format(aa))
      })
    },
  })
}


function sendSubmitRequest(id) {
    // $("#sendDataEntetainment".id).attr("action", amadeusPathByLang + 'submitRequest');
    $("#sendDataEntetainment"+id).submit();

}

function GetCitiesOnSelectBox(thiss, country_id,city_id=null,category_id=null) {
  var citiesArray = ""
  $.ajax({
    type: "post",
    url: amadeusPath + "entertainment_ajax.php",
    data: {
      flag: "getEntertainmentCities",
      country_id: thiss.val(),
    },
    success: function (response) {
      var cities = JSON.parse(response)

        if ($("#EntertainmentCity").data("select2")) {
          $("#EntertainmentCity").select2("destroy")
        }
      citiesArray +="<option value='all'> " + useXmltag("All") + " </option>";
      $.each(cities, function (index, value) {
        citiesArray +=
          "<option " +
          (value.id === city_id ? "selected" : "") +
          ' value="' +
          value.id +
          '">' +
          value.name +
          "</option>"
      })

      console.log('citiesArray',citiesArray)
        $("#EntertainmentCity").html(citiesArray)
        $("#EntertainmentCity").select2()

      GetCategoriesOnSelectBox($('#EntertainmentCity'),'0',category_id)
    },
  })
}

function GetCategoriesOnSelectBox(thiss, parent_id,category_id=null) {
  var citiesArray = ""
  $.ajax({
    type: "post",
    url: amadeusPath + "entertainment_ajax.php",
    data: {
      flag: "getCategories",
      parent_id: parent_id,
      city_id: thiss.val(),
    },
    success: function (response) {
      var categories = JSON.parse(response)

        if ($("#EntertainmentCategory").data("select2")) {
          $("#EntertainmentCategory").select2("destroy")
        }

      let last_category_id = ""
      $.each(categories, function (index, value) {
         citiesArray +=
            "<option " +
            (value.id === category_id ? "selected" : "") +
            ' value="' +
            value.id +
            '">' +
            value.title +
            "</option>"
         last_category_id = value.id
      })

        $("#EntertainmentCategory").html(citiesArray)
        $("#EntertainmentCategory").select2()
      GetSubCategoriesOnSelectBox(last_category_id)
    },
  })
}
function GetSubCategoriesOnSelectBox(category_id) {
  var citiesArray = ""



  $.ajax({
    type: "post",
    url: amadeusPath + "entertainment_ajax.php",
    data: {
      flag: "getSubCategories",
      parent_id: category_id,
      city_id: $('#EntertainmentCity').val(),
    },
    success: function (response) {
      var categories = JSON.parse(response)

      if ($("#EntertainmentSubCategory").data("select2")) {
        $("#EntertainmentSubCategory").select2("destroy")
      }

      $.each(categories, function (index, value) {
        citiesArray +=
          "<option " +
          (value.id === category_id ? "selected" : "") +
          ' value="' +
          value.id +
          '">' +
          value.title +
          "</option>"
      })

      $("#EntertainmentSubCategory").html(citiesArray)
      $("#EntertainmentSubCategory").select2()

    },
  })
}

function GetCountriesOnSelectBox(thiss, country_id,city_id=null) {
  var citiesArray = ""
  $.ajax({
    type: "post",
    url: amadeusPath + "entertainment_ajax.php",
    data: {
      flag: "getEntertainmentCities",
      country_id: thiss.val(),
    },
    success: function (response) {
      var cities = JSON.parse(response)

        if ($("#EntertainmentCity").data("select2")) {
          $("#EntertainmentCity").select2("destroy")
        }
      citiesArray +="<option value='all'> " + useXmltag("All") + " </option>";
      $.each(cities, function (index, value) {
        citiesArray +=
          "<option " +
          (value.id === city_id ? "selected" : "") +
          ' value="' +
          value.id +
          '">' +
          value.name +
          "</option>"
      })

        $("#EntertainmentCity").html(citiesArray)
        $("#EntertainmentCity").select2()


    },
  })
}



$(document).ready(function () {
  $("#inputSearch").keyup(function () {
    var hotels = $(".RepeatableDiv")
    var inputSearch = $("#inputSearch").val()

    hotels
      .hide()
      .filter(function () {
        var hotelName = $(this)
          .find('[data-mode="ajax"][data-target="title"] [data-target="value"]')
          .text()
        var search = hotelName.indexOf(inputSearch)
        if (search > -1) {
          return hotelName
        }
      })
      .show()
  })
  $(".view_list_grid").click(function () {
    $(".view_list_grid").removeClass("active_g_list_a")
    $(this).addClass("active_g_list_a")
    $(".BaseDiv .RepeatableDiv").each(function () {
      $(this).addClass("col-md-4")
      $(this).find(".tasvir_tour").removeClass("col-md-12").addClass("col-md-4")
      $(this).find(".tasvir_tour").removeClass("col-md-12").addClass("col-md-4")
      $(this)
        .find(".res_tour_matn")
        .removeClass("col-md-12")
        .addClass("col-md-8")
    })
  })

  $("#view_grid_a").click(function () {
    $(".BaseDiv").addClass("actived_entertainment_grid")

    $(".BaseDiv .RepeatableDiv").each(function () {
      $(this).addClass("col-md-4")
      $(this).find(".tasvir_tour").removeClass("col-md-4").addClass("col-md-12")
      $(this).find(".tasvir_tour").removeClass("col-md-8").addClass("col-md-12")
      $(this)
        .find(".res_tour_matn")
        .removeClass("col-md-8")
        .addClass("col-md-12")
    })
  })

  $("#view_list_a").click(function () {
    $(".BaseDiv").removeClass("actived_entertainment_grid")

    $(".hotel-result-item .tasvir_tour").addClass("col-md-4")
    $(".hotel-result-item .res_tour_matn").addClass("col-md-8")

    $(".BaseDiv .RepeatableDiv").each(function () {
      $(this).removeClass("col-md-4")
    })
  })
})

function submit_tafrih_form_js() {
  var category_id = $("#select_tafrih_searchbox").val()
  var subcategory_id = $("#EntertainmentSubCategory").val()

  var domain = $("#entertainmentForm").attr("data-action")
  var url = amadeusPathByLang + "resultEntertainment/" + subcategory_id
  console.log(url)
  $("#entertainmentForm").attr("target", "_blank")
  $("#entertainmentForm").attr("action", url)

  return document.entertainmentForm.submit()
}




function submitRequestEntertainment(_this){

  const requestedMemberName=$('#requestedMemberName').val()
  const requestedMemberPhoneNumber=$('#requestedMemberPhoneNumber').val()

  $.post(amadeusPath + 'hotel_ajax.php',
    {
      Email: requestedMemberPhoneNumber,
      flag: "register_memeberHotel"
    },
    function (data) {
      if (data != "") {

        $('#idMember').val(data);

      } else {

        /*   $.alert({
             title:  useXmltag("Tourreservation"),
             icon: 'fa fa-cart-plus',
             content: useXmltag("Errorrecordinginformation"),
             rtl: true,
             type: 'red'
           });
           return false;*/
      }
    });


  // $('#requestForm').append('<input type="hidden" name="className" value="requestReservation" />');
  // $('#requestForm').append('<input type="hidden" name="method" value="create" />');

  const serviceName=$('#serviceName').val()
  $('#requestForm').append('<input type="hidden" id="requestedMemberName" name="requestedMemberName" value="'+requestedMemberName+'" />');
  $('#requestForm').append('<input type="hidden" id="requestedMemberPhoneNumber" name="requestedMemberPhoneNumber" value="'+requestedMemberPhoneNumber+'" />');
  $('#requestForm').append('<input type="hidden" name="serviceName" value="'+serviceName+'" />');



  setTimeout(
    function () {
      $('#requestForm').submit();
    }, 300);


}
