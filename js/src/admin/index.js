import app from 'flarum/app';
import RedisStatusWidget from './extend/RedisStatusWidget';

app.initializers.add('blomstra-redis', () => {
    RedisStatusWidget();

    app.extensionData
		.for('blomstra-redis')
		.registerSetting({
			setting: 'blomstra-redis.enableCache',
			type: 'boolean',
			label: app.translator.trans('blomstra-redis.admin.settings.enable_cache'),
		})
		.registerSetting({
			setting: 'blomstra-redis.redisSessions',
			type: 'boolean',
			label: app.translator.trans(
				'blomstra-redis.admin.settings.enable_redis_sessions'
			),
		})
		.registerSetting({
			setting: 'blomstra-redis.enableQueue',
			type: 'boolean',
			label: app.translator.trans('blomstra-redis.admin.settings.enable_queue'),
		});
});
