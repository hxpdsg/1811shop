<?php
 return [
		//应用ID,您的APPID。
        'app_id' => "2016092600603164",
        'seller_id'=>"2088102177408745",
        

		//商户私钥
		'merchant_private_key' => "MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCxL5SnJjU0s8XYrRbpNeg5B8ceF9rN28qXQa5Ki4+st0DF93bXvf1UyfxqVdTrzbaxXbZib+OPHwxP33bDj5PAuzgynsGVEJ7F1O4hlYjViOPRjd+U1zmyGH9f6U3FnonjOm5/Z9pi2ezM84kN7ChG5Hpd4/iCR3K6dDIvrmobubYnq2ksV9qfeb07MrO6hKxrCcEUafT+iK41cuCZDIQvdowXvHlKZAeQdk4aOqV1OK0+5FCktc0P60U5IVUpSRiF3CayhFjJ+hOVfvZXp7TMvb3t0iyPyxecXhJFC29Cypm6FCJAUjtWtejhWnSoWlzr8RuOtZcKaxoBn5TH9YkHAgMBAAECggEAdI9xgjgfXkk5SR4s6UQePY5BTimxNiV18+UwbDe9T4jKIrF1y91fTy0FUUqfpHQS0EFu3vjuQVPSfKTr8yB7uZkwEhTgElj5qfk2on9FofvIqy1ivP6NJPz6pjTLhcqSuRnSYRwHzWnBXt6C9da6dFCPsz5qWAH6lnAkJ7vcb9mzWIB9KN72RdB1mGTv00dCpy2JzkQ5u8i86KaPOL1z5fTgAVtUvGHqUYQpS0xViZIOeOeiTOo+Sbxysy1zPtomJ7aSnV8kRUSD/A3aWEJgFnIyAP0lgoshKbe9Px8lxu+5iOXLnWUyz4dVQGwT9KtTnDPR8tTmmkeHwiDK4d+l8QKBgQD4QYZ/SVIDeFeBb7ir1hiSkxgdwzfm7KVTypcrLP1AmOcqH21j0hq1fUfivQYSvcF/9oEwQhJFph292qg1uGqPTfRpwVX5CKZB3ONj9JaaIGF8lxO73SfDUCr4fvPgpShOBvWaRfmvag3JfX11888Ao5YV5lFc2jGt1/w8cu8eCQKBgQC2toR0yJ3HNgJ8ufl9/VTIhYfm82mS/UZgC1IidSuXAcy0FWWI0icE6+MzC+TpU8PSpaownDuoBjbXK6TaUncIX4Aq42gdvEB10S38XZyPLPYdcXgsnalerxVydPjk+1Y0cXfScBbcSI/8hjfIbzrSw5gCW78G30Kt8Ell3dYyjwKBgDtoWsos/o5MBwy3cobUdg7lWlkM9VyydqHFkkVHv9bsgC0JVkET70ZNE53DxCdJ93sqvyGQPhUium1LXQN1/TIL4phIJs2wbzDFrjimOD/rzchl0tgbBT/s+Et8/dldTHbXnYBsjGKYy3HTMOnADWJGw0y8T+4bXNYQIJFKo8QZAoGAQER62skmFkg9H7oas+JDzDSL1QSRgg5sjqPsxAoKxxbu9fkAuduRtf1y8SWh4yB/pLx43JhXs4ZcC9tiJRkUnXFaF7vdh3gMBGULk9UpmILsHvcmmirqxE85cAUM9x4g+FlhGDgtElbDrsNXI71cJ359HXc//h7RyXTXnGknSqkCgYEA4YM9vI4ZTk6jcaHpHsian0tJ4v1u0m5okpZxwDuUtNs5/B370daZKozB3azcl4jEjxVpBqPVvcC5OXY0aaGX8NpJoaYhWQcjRTusLtPjR0SjJ7s7i5oG1S7zJXaQ+o5iLTjX7SjjoZLfesvrISSRNh+2JHnEDFk6eTGkjtMk4BM=",
		
		//异步通知地址
		'notify_url' => "http://39.96.202.30",
		
		//同步跳转
		'return_url' => "http://www.la.com/returnpay",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAmBCBcoTWDTnqjMOXKcR9Xfx6rJ1xRGQh5PB7mPpkmhkERJY8GVQlagJIN2C0MW4llvenHrZNaQ89pjcnoUAD5bxxWXJpk4ouHcifGISr9gAhn2kERT3jOLfATM4gCGkdF78+jtst+HWccRbLhEhCc1Xnlq7Wtt1XqLL97ZlPeLjoADUKyMFaVl5SgD/9GYFw28nO3uLYT1l4xlUJ6iJCOGtACUzSIYnhCE/cbJcE4pniARLsge3EQAAGzyOeD/295w3B22h8UY9B3jchhDbghDMPRAMfsDmq2budqWEVOHzE1wds46FYRPn3nWgPk8ecYxB4UXLMNwQ0tSdpruoFPwIDAQAB",
];