import app from 'flarum/app';
import { extend } from 'flarum/extend';
import StatusWidget from 'flarum/admin/components/StatusWidget';

app.initializers.add('blomstra-redis', () => {
  extend(StatusWidget.prototype, 'items', items => {
    const loads = app.data.blomstraQueuesLoad;

    for(let queue of app.data.blomstraQueuesSeen) {
        const load = loads[queue] || null;
        items.add('blomstra-queue-size-' + queue, [<strong>Queue {queue}</strong>, <br/>, load || '0']);
    }
  });
});
