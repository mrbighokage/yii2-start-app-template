// select null
$query->andFilterWhere(['not', [$attribute => 'NULL']])
$query->andFilterWhere(['is', $attribute, new Expression('NULL')])
