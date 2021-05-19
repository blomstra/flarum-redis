import { extend } from 'flarum/common/extend';
import StatusWidget from 'flarum/admin/components/StatusWidget';

export default function () {
    extend(StatusWidget.prototype, 'items', (items) => {
        if (app.data.blomstraQueuesSeen === undefined) { return; }

        const loads = app.data.blomstraQueuesLoad;

        for (let queue of app.data.blomstraQueuesSeen) {
            const load = loads[queue] || null;
            items.add('blomstra-queue-size-' + queue, [<strong>Queue {queue}</strong>, <br />, load || '0']);
        }
    });
}
