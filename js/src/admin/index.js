import app from 'flarum/app';
import { extend } from 'flarum/extend';
import StatusWidget from 'flarum/components/StatusWidget';

app.initializers.add('bokt-redis', () => {
  extend(StatusWidget.prototype, 'items', items => {
    const loads = app.data.boktQueuesLoad;

    for(let queue of app.data.boktQueuesSeen) {
        const load = loads[queue] || null;
        items.add('bokt-queue-size-' + queue, [<strong>Queue {queue}</strong>, <br/>, load || '0']);
    }
  });
});
