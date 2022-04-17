# Currency Conversion
版本資訊：
Laravel : 9
PHP     : 8
此 project 為實作匯率轉換，
使用 Repository Pattern and Service Layer 進行實作，
Controller 只需要負責與 Service 溝通，其他事情交給 Service 做即可。

## API
- [GET] api/conversion 轉換匯率 API

## Validator
負責驗證 request 的值。
- App\Http\Requests\CurrencyConversionRequest
    - 驗證 from   欄位 required|string
    - 驗證 to     欄位 required|string
    - 驗證 amount 欄位 required|integer

## Services
負責取得、轉換匯率，以及輸出的格式。
- App\Services\CurrencyConversionService
    - [method] convert - 轉換匯率
    - [method] format  - 轉換格式
- App\Services\ExchangeRateService
    - [method] getRatio - 取得匯率

## Repositories
負責資料庫溝通。

## Exception
Service 或 Repository 可以丟出特定的 exception，最後在 Controller 進行 try catch。
- App\Exceptions\ConversionExcaption

## Trait
使用 App\Trait\ResponseTrait 來統一回傳的格式，格式範例為以下：
```json
{
    "status"  : true,
    "message" : "some message",
    "data"    : {}
}
```

## Tests
- API test
    - test_currency_conversion