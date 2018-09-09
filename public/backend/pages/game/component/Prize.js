$(function () {
  var prizes = $('#json_prize').val() !== '' ? JSON.parse($('#json_prize').val()) : [];
  var Prize = new Ractive({
    target: '#prize-table',
    template: `
        {{#each prizes}}
      <tr fade-in fade-out>
        <td>
            <input class="form-control" type="text" name="prize_name[{{ _id }}]" title="" value="{{ name }}">
        </td>
        <td>
            <input class="form-control" type="number" name="prize_match[{{ _id }}]" title="" value="{{ match }}">
        </td>
        <td>
            <input type="number" class="form-control" name="prize_match_special[{{ _id }}]" title="" value="{{match_special}}">
        </td>
        <td>
            <input class="form-control" type="number" name="prize_value[{{ _id }}]" title="" value="{{ value }}">
        </td>
        <td>
            <input class="form-control" type="text" name="prize_unit[{{ _id }}]" title="" value="{{ unit }}">
        </td>
        <td>
            <button class="btn btn-danger" type="button" on-click="['deletePrize', _id]"><i class="fa fa-trash"></i></button>
        </td>
      </tr>
      {{/each}}
      <tr>
        <td>
            <input class="form-control" type="text" title="" value="{{ new_name }}">
        </td>
        <td>
            <input class="form-control" type="number" title="" value="{{ new_match }}">
        </td>
        <td>
            <input type="number" class="form-control" id="new_match_special" value="{{ new_match_special }}">
        </td>
        <td>
            <input class="form-control" type="number" title="" value="{{ new_value }}">
        </td>
        <td>
            <input class="form-control" type="text" title="" value="{{ new_unit }}">
        </td>
        <td>
            <button class="btn btn-primary" type="button" on-click="['addPrize']"><i class="fa fa-save"></i></button>
        </td>
      </tr>
    `,
    data: {
      prizes: prizes
    },
    on: {
      addPrize: function () {
        var self = this;
        var newRow = {
          _id: uuidv1(),
          name: this.get('new_name'),
          match: this.get('new_match'),
          match_special: this.get('new_match_special'),
          value: this.get('new_value'),
          unit: this.get('new_unit')
        };

        for(prop in newRow) {
          if(prop !== 'match_special' && (newRow[prop] === null || newRow[prop] === '' || newRow[prop] === undefined)) {
            return false;
          }
        }

        prizes = this.get('prizes');
        prizes.push(newRow);
        this.set('prizes', prizes).then(function() {
          self.set('new_name', null);
          self.set('new_match', null);
          self.set('new_match_special', null);
          self.set('new_value', null);
          self.set('new_unit', null);
        });
      },
      deletePrize: function (context, uuid) {
        prizes = this.get('prizes');
        prizes = prizes.filter(function( obj ) {
          return obj._id !== uuid;
        });
        this.set('prizes', prizes);
      }
    }
  });
});